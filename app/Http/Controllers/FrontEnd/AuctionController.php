<?php

namespace App\Http\Controllers\FrontEnd;

use App\Auction;
use App\AuctionBid;
use App\Console\Commands\Auction as CommandsAuction;
use App\Events\AuctionBid as EventsAuctionBid;
use App\FundSize;
use App\Http\Controllers\BackEnd\AccessController;
use App\Http\Controllers\Controller;
use App\Leads;
use App\ServiceOffer;
use App\System;
use App\TremsAndCondition;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AuctionController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#','remain_time',  'auction_time', 'type', 'reserve_price', "buy_out_price",'current_bid_price', "min_bid_price", 'top_bidder', 'status', 'post_code', 'reason', 'question', 'communication_type', 'fund_size', 'area_of_advice',   'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'remain_time', 'auction_time', 'type', 'base_price', 'buy_out_price','current_bid_price', "min_bid_price", 'max_bidder', 'status',  'post_code','primary_reason',  'question', 'communication_type', 'fund_size', 'area_of_advice',  'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Auction();
    }

    /**
     * Show auction List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        

        //$this->saveActivity($request, "View Auction Table");
        
        $params = [
            'nav'               => 'auction',
            'subNav'            => 'auction.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'auction List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            "enable_trems_and_condition"=> $request->user()->accept_auction_condition
            
        ];
        return view('frontEnd.advisor.auction.table', $params);
    }

    /**
     * Show Search Local auction List 
     */
    public function searchLocally(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request, 'search_locally');
        }
        
        //$this->saveActivity($request, "View Search Local Auction Table");
        $params = [
            'nav'               => 'auction',
            'subNav'            => 'auction.search_locally',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Search Local Auction List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            "enable_trems_and_condition"=> $request->user()->accept_auction_condition
            
        ];
        return view('frontEnd.advisor.auction.table', $params);
    }

    /**
     * Show Match Me auction List 
     */
    public function matchMe(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request, 'match_me');
        }
        
        //$this->saveActivity($request, "View Match Me Auction Table");
        $params = [
            'nav'               => 'auction',
            'subNav'            => 'auction.match_me',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Match Me Auction List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            "enable_trems_and_condition"=> $request->user()->accept_auction_condition
            
        ];
        return view('frontEnd.advisor.auction.table', $params);
    }

    /**
     * Show bid page
     */
    public function bidPage(Request $request){
        $auction = $this->getModel()->where('id', $request->id)->where('end_time', '>=', now()->format('Y-m-d H:i:s'))->where('start_time', '<=', now()->format('Y-m-d H:i:s'))->first();
        if( !empty($auction) ){
            $bid = AuctionBid::where('auction_id', $auction->id)->where('bidder_id', $request->user()->id)->first();
        }
        $params = [
            "title"     => "Auction Bid Page",
            "form_url"  => route('advisor.auction.bid',[$auction->id]),
            "auction"   => $auction,
            'advisor'   => $auction->max_bidder ?? Null,
            'bid'       => $bid ?? Null,
        ];
        //$this->saveActivity($request, "View Auction Bid Page");
        return view('frontEnd.advisor.auction.bid', $params)->render();
    }

    /**
     * Save / Update auction Information
     */
    public function bid(Request $request){        
        try{
            DB::beginTransaction();
            $auction = $this->getModel()->where('id', $request->id)->where('end_time', '>=', now()->format('Y-m-d H:i:s'))->where('status', 'running')->first();
            
            if( empty($auction) ){
                $this->message = "Sorry! This Auction's BID time has been expired Or auction is not running at this time. You can't bid";
                return $this->output();
            }
            // $bid = AuctionBid::where('auction_id', $auction->id)->where('bidder_id', $request->user()->id)->first();
            $min_bid_price = $auction->base_price > $auction->min_bid_price ? ($auction->base_price) : ($auction->min_bid_price);
            
            if( empty($request->min_bid_price) || $request->min_bid_price < $min_bid_price){
                $this->message = "Sorry! You can't bid lower than minimum BID price";
                return $this->output();
            }
            
            $bid = new AuctionBid();
            $bid->auction_id = $auction->id;
            $bid->bidder_id  = $request->user()->id;
            $bid->bid_price  = $request->min_bid_price;
            $bid->save();

            $auction->min_bid_price = ($bid->bid_price + $auction->bid_increment);
            $auction->max_bidder_id = $request->user()->id;
            $auction->save();

            if($auction->buy_out_price != 0 && $auction->buy_out_price <= $bid->bid_price){
                $buy_out_mail_send = !empty($request->buy_out) && $request->buy_out == 1 ? true : false;
                (new CommandsAuction())->completeAuction($auction, $buy_out_mail_send);
                
                $msg = "Buy out button on ".$auction-> post_code. " for £".$auction->buy_out_price. " activated ";

                //$msg = implode(' ', array($postcode, $reserveprice,$buyoutprice , $primaryregion, $name));
                $this->saveActivity($request, $msg);
            }
            else{
                event(new EventsAuctionBid($auction));
            }
            
            DB::commit();           
            
            
            $this->success('Your bid has been submitted successfully');
            
            $auction = $this->getModel()->where('auctions.id', $request->id)->select('auctions.*')->first();
            
            //New Activity Message
            $id =  $request->user()->id;
            $name = User::where('id', $id)->first(['first_name'])->first_name;
            $postcode = "Auction bid for lead ".$auction-> post_code;
            $reserveprice =  ",<br> reserve price £".$request->min_bid_price.".00" ;
            $buyoutprice = ", <br>buy out price £".$auction->buy_out_price .".00"  ;
            $primaryregion = ", <br>sent to ".$auction->primary_reason();
            
            $msg = "Bid made on ".$auction-> post_code. " for £".$request->min_bid_price;

            //$msg = implode(' ', array($postcode, $reserveprice,$buyoutprice , $primaryregion, $name));
            $this->saveActivity($request, $msg);
            
        }catch(Exception $e){
            DB::rollBack();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    
    /**
     * View Auction Details
     */
    public function view(Request $request){
        $auction = $this->getModel()->where('auctions.id', $request->id)->select('auctions.*')->first();
        $params = [
            'auction'   => $auction,
            'advisor'    => $auction->max_bidder ?? Null,
        ];
        return view('frontEnd.advisor.auction.view', $params);
    }

    /**
     * View COndition
     */
    public function viewTermsAndCondition(Request $request){
        $trems_and_condition = TremsAndCondition::where("type", "Auction Terms & Conditions")
            ->orWhere("type", "Sign up")->first();
        $params = [
            'trems_and_condition'   => $trems_and_condition,
        ];
        return view('frontEnd.advisor.auction.view-terms-and-condition', $params);
    }

    /**
     * Accept Suction Condition
     */
    public function acceptTermsAndCondition(Request $request){
        try{
            DB::beginTransaction();
            User::where("id", $request->user()->id)->update(["accept_auction_condition" => true]);
            $this->saveActivity($request, "Accept auction's terms and condition");
            DB::commit();
            return "success";
        }catch(Exception $e){
            DB::rollBack();
            return "error";
        }
    }


    /**
     * Get auction DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($request, $type = 'list'){
        $data = $this->getModel();
        if( $type == "list" ){
            $data = $data->orderBy('start_time', 'DESC')->orderBy('auctions.id','DESC');
        }
        elseif($type == "match_me"){
            $data = $data->where('leads.type', 'match me')->orderBy('start_time', 'DESC')->orderBy('auctions.id','DESC');
        }
        elseif($type == "search_locally"){
            $data = $data->where('leads.type', 'search local')->orderBy('start_time', 'DESC')->orderBy('auctions.id','DESC');
        }else{
            $data = $data->onlyTrashed();
        }
        if($request->status != "all"){
            $data = $data->where('status', $request->status);
        }
        $data = $data->get();
        $system = System::first();

        return DataTables::of($data)
        ->addColumn('index', function(){ return ++$this->index; })
        ->addColumn('max_bidder', function($row){ return isset($row->max_bidder->first_name) ? ($row->max_bidder->first_name . ' ' . $row->max_bidder->last_name) : "N/A"; })
        ->editColumn('base_price', function($row) use($system){ 
            return $row->base_price == 0 ? 'No reserve price' : ($system->currency_symbol.number_format($row->base_price, 2)); 
        })
        ->editColumn('buy_out_price', function($row) use($system){ return $system->currency_symbol. number_format($row->buy_out_price ?? 0, 2); })
        ->editColumn('current_bid_price', function($row) use($system){ return $system->currency_symbol. number_format($row->bid_win->bid_price ?? 0, 2); })
        ->editColumn('min_bid_price', function($row) use($system){ return $system->currency_symbol. number_format($row->min_bid_price, 2); })
        ->addColumn('question', function($row){ return wordwrap($row->question ?? "", "60", "<br>"); })
        ->addColumn('fund_size', function($row){ return $row->fund_size->name ?? "N/A"; })         
        ->addColumn('primary_reason', function($row){ return str_replace(',', ',<br>', $row->primary_reason()); })
        ->addColumn('area_of_advice', function($row){ return str_replace(',', ',<br>', $row->service_offered()); })
        ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
        ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
        ->editColumn("type", function($row){ return ucwords($row->type); })
        ->addColumn('auction_time', function($row) use ($system){
            return Carbon::parse($row->start_time)->format($system->date_format. ' h:i A') . '<br> To <br> ' . Carbon::parse($row->end_time)->format($system->date_format. ' h:i A');
        })
        ->addColumn('remain_time', function($row){
            if($row->status == "cancelled"){
                return "N/A";
            }elseif( $row->end_time > now() ){
                return $this->getTimeDiffrent(now(), $row->end_time);
            }else{
                return "Finished";
            }
        })
        ->editColumn("status", function($row){ 
            if($row->status == "cancelled"){
                return $this->getStatus($row->status);
            }
            elseif( $row->start_time > now() ){
                return $this->getStatus("not_started");
            }elseif( now() >= $row->start_time && now() <= $row->end_time ){
                return $this->getStatus("running");
            }else{
                return $this->getStatus("completed");
            }
        })
        ->addColumn('action', function($row){                
            $li = '<a href="'.route('advisor.auction.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="View Details" > <span class="fa fa-eye"></span> </a> ';
            if( (now() >= $row->start_time && now() <= $row->end_time) && $row->status != "cancelled" ){
                $li .= '<a href="'.route('advisor.auction.bid',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="Bid Now" > <span class="fa fa-edit"></span> Bid</a> ';
            }
            return $li;
        })
        ->rawColumns(['action', 'status', 'question',"primary_reason", "area_of_advice", "auction_time"])
        ->make(true);
    }

    
}
