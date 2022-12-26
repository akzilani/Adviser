<?php

namespace App\Http\Controllers\BackEnd;

use App\ActivityLog;
use App\Auction;
use App\EmailOption;
use App\Events\AuctionCancel;
use App\Events\AuctionCreated;
use App\FundSize;
use App\Http\Controllers\Controller;
use App\Leads;
use App\PrimaryReason;
use App\Profession;
use App\ServiceOffer;
use App\System;
use App\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AuctionController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'remain_time', 'auction_time', 'type', 'post_code', 'question', 'communication_type', 'fund_size', 'area_of_advice', 'reserve_price', 'buy_out_price', 'current_bid_price', "final_bid_price",'top_bidder', 'status', 'reason', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'remain_time', 'auction_time', 'type', 'post_code', 'question', 'communication_type', 'fund_size', 'area_of_advice', 'base_price', 'buy_out_price', 'current_bid_price', "final_bid_price", 'max_bidder', 'status',  'primary_reason', 'action'];
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
        
        $params = [
            'nav'               => 'auction',
            'subNav'            => 'auction.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            "create"            => AccessController::checkAccess("auction_create") ? route('auction.create') : false,
            'pageTitle'         => 'Auction List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-xl",
            'table_responsive'  => "table-responsive",
        ];
        return view('backEnd.auction.table', $params);
    }

    /**
     * Show auction Archive List  without Archive
     */
    public function archiveList(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request, "archive");
        }
        
        $params = [
            'nav'               => 'auction',
            'subNav'            => 'auction.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Deleted Auction List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-xl",
            'table_responsive'  => "table-responsive",
        ];
        return view('backEnd.auction.table', $params);
    }

    /**
     * Show Search Local auction List 
     */
    public function searchLocally(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request, 'search_locally');
        }
        
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
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Show Match Me auction List 
     */
    public function matchMe(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request, 'match_me');
        }
        
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
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Auction
     */
    public function create(Request $request){
        $params = [
            "title"         => "Create Auction",
            "form_url"      => route('auction.create'),
            "reasons"       => PrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
            'service_offer' => ServiceOffer::where('publication_status', 1)->orderBy('position','ASC')->get(),
            "fund_sizes"    => FundSize::where('publication_status', 1)->get(),
            "professions"   => Profession::where("publication_status", true)->get(),
        ];
        //$this->saveActivity($request, "Create Auction Page Open");
        return view('backEnd.auction.create', $params)->render();
    }

    /**
     * Edit auction Info
     */
    public function edit(Request $request){
        $auction = $this->getModel()->find($request->id);
        $params = [
            "title"         => "Edit Auction",
            "form_url"      => route('auction.create',[$auction->lead_id]),
            "data"          => $auction,
            "reasons"       => PrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
            'service_offer' => ServiceOffer::where('publication_status', 1)->orderBy('position','ASC')->get(),
            "fund_sizes"    => FundSize::where('publication_status', 1)->orderBy("min_fund", "ASC")->get(),
            "professions"   => Profession::where("publication_status", true)->get(),
        ];
        //$this->saveActivity($request, "Edit Auction Page Open");
        return view('backEnd.auction.create', $params)->render();
    }

    /**
     * Save / Update auction Information
     */
    public function store(Request $request){        
        if( !AccessController::checkAccess('auction_create') ){
            return $this->accessDenie();
        }
        try{
            $validator = Validator::make($request->all(),[
                "fund_size_id"          => ['required','numeric','min:1'],
                "profession_id"         => ['required','numeric','exists:professions,id'],
                'question'              => ['required','string', 'min:2', 'max:2500'],
                'service_offer_id.*'    => ['required','numeric'],
                'primary_region_id.*'   => ['required','numeric'],
                'communication_type'    => ['nullable','string', 'min:2', 'max:191'],
                'start_date'            => ['required'],
                'start_time'            => ['required', 'date_format:H:i'],
                'end_time'              => ['required', 'string'],
                'base_price'            => ['required','numeric','min:0'],
                'post_code'             => ['required', 'string']
            ]);
            
            if( $validator->fails()){
                $this->message = $this->getValidationError($validator);
                $this->modal = false;
                return $this->output();
            }
            
            if( $request->id == 0 ){
                if( !AccessController::checkAccess('auction_create') ){
                    return $this->accessDenie();
                }
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Auction information added successfully';
            }else{
                if( !AccessController::checkAccess('auction_update') ){
                    return $this->accessDenie();
                }
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $message = 'Auction information updated successfully';
            } 
            
            if($request->start_time < date('H:i:s')){
                $request->start_time = date('H:i:s');
            }
                                  
            $data->primary_region_id    = $request->primary_region_id;
            $data->fund_size_id         = $request->fund_size_id;
            $data->profession_id        = $request->profession_id;
            $data->post_code            = $request->post_code;
            $data->communication_type   = $request->communication_type;
            $data->start_time       = $request->start_date .' '.$request->start_time;
            $data->end_time         = $this->getEndTime($request);
            $data->duration         = $request->end_time;
            $data->base_price       = $request->base_price; // base price ==> Reserve Price                        
            $data->min_bid_price    = $request->base_price;                     
            $data->buy_out_price    = $request->buy_out_price;                     
            $data->bid_increment    = $request->bid_increment;                        
            $data->status           = $request->status;
            $data->service_offer_id = $request->service_offer_id;                       
            $data->question         = $request->question;                       
            $data->type             = $request->type;
            $data->save();
            
            //New Activity 
            $activity = "Auction ". ($request->id == 0 ? "Created " : "updated") ." for ". $data->post_code.",
                <br>Reserve price £" . $data->base_price . ",
                <br>Buy out price £". $data->buy_out_price .",
                <br>Sent to, " . $data->primary_reason();
            $this->saveActivity($request, $activity);

            if($request->mail_send){
                event(new AuctionCreated($data));
            }

            if($data->status == "cancelled"){
                $activity = "Auction "." on ". $data->post_code." cancelled";
                $this->saveActivity($request, $activity);

                event(new AuctionCancel($data));
            }
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Calculate & return End Time
     */
    public function getEndTime($request){
        $start_time = $request->start_date .' '.$request->start_time;
        $end_time = "";
        switch ($request->end_time) {
            case '20 min':
                $end_time = Carbon::parse($start_time)->addMinutes(20);
                break;
            case '40 min':
                $end_time = Carbon::parse($start_time)->addMinutes(40);
                break;
            case '60 min':
                $end_time = Carbon::parse($start_time)->addMinutes(60);
                break;
            case '2 hours':
                $end_time = Carbon::parse($start_time)->addHours(2);
                break;
            case '3 hours':
                $end_time = Carbon::parse($start_time)->addHours(3);
                break;
            case '4 hours':
                $end_time = Carbon::parse($start_time)->addHours(4);
                break;
            case '5 hours':
                $end_time = Carbon::parse($start_time)->addHours(5);
                break;
            case '6 hours':
                $end_time = Carbon::parse($start_time)->addHours(6);
                break;
            case '7 hours':
                $end_time = Carbon::parse($start_time)->addHours(7);
                break;
            case '8 hours':
                $end_time = Carbon::parse($start_time)->addHours(8);
                break;
            case '9 hours':
                $end_time = Carbon::parse($start_time)->addHours(9);
                break;
            case '10 hours':
                $end_time = Carbon::parse($start_time)->addHours(10);
                break;
            case '11 hours':
                $end_time = Carbon::parse($start_time)->addHours(11);
                break;
            case '12 hours':
                $end_time = Carbon::parse($start_time)->addHours(12);
                break;
            case '24 hours':
                $end_time = Carbon::parse($start_time)->addHours(24);
                break;
            case '48 hours':
                $end_time = Carbon::parse($start_time)->addHours(48);
                break;
            case '72 hours':
                $end_time = Carbon::parse($start_time)->addHours(72);
                break;
            default:
                $end_time = Carbon::parse($start_time)->addYear(100);
                break;
        }
        return $end_time;
    }
    
    /**
     * View Auction Details
     */
    public function view(Request $request){
        $auction = $this->getModel()->find($request->id);
        $params = [
            'auction'   => $auction,
            'advisor'    => $auction->max_bidder ?? Null,
        ];
        return view('backEnd.auction.view', $params);
    }

    /**
     * Make the selected auction As Archive
     */
    public function archive(Request $request,$id){
        try{

            $data_auction = $this->getModel()->find($request->id);
            $post_code=$data_auction->post_code;
            $data_auction->delete();
            $this->success('Archive deleted successfully');

            $this->saveActivity($request, "Auction ".$post_code. " deleted");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected auction As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Auction restored successfully');
            $this->saveActivity($request, "Auction restored");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected auction As Active from Archive
     */
    public function delete(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->forceDelete();
            $this->success('Auction Deleted successfully');
            $this->saveActivity($request, "Auction Deleted");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }


    /**
     * Get auction DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($request, $type = 'list'){
        $data = $this->getModel();
        if( $type == "list" ){
            $data = $data->orderBy('auctions.id','DESC');
        }
        elseif($type == "match_me"){
            $data = $data->where('type', 'match me')->orderBy('auctions.id','DESC');
        }
        elseif($type == "search_locally"){
            $data = $data->where('type', 'search local')->orderBy('auctions.id','DESC');
        }else{
            $data = $data->onlyTrashed();
        }
        if($request->status != "all" && $request->status){
            $data = $data->where('status', $request->status);
        }
        $data = $data->get();
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('max_bidder', function($row){ return isset($row->max_bidder->first_name) ? ($row->max_bidder->first_name . ' ' . $row->max_bidder->last_name) : "N/A"; })
            ->editColumn('base_price', function($row) use($system){ 
                return $row->base_price == 0 ? 'No reserve price' : ($system->currency_symbol. number_format($row->base_price, 2)); 
            })
            ->editColumn('buy_out_price', function($row) use($system){ return $system->currency_symbol. number_format($row->buy_out_price ?? 0, 2); })
            ->editColumn('current_bid_price', function($row) use($system){ return $system->currency_symbol. number_format($row->bid_win->bid_price ?? 0, 2); })
            ->editColumn('min_bid_price', function($row) use($system){ return $system->currency_symbol. number_format($row->min_bid_price, 2); })
            ->editColumn('final_bid_price', function($row) use($system){ return $system->currency_symbol. number_format($row->bid_win->bid_price ?? 0, 2); })
            ->addColumn('question', function($row){ return wordwrap($row->question ?? "", "60", "<br>"); })
            ->addColumn('fund_size', function($row){ return $row->fund_size->name ?? "N/A"; })         
            ->addColumn('primary_reason', function($row){ return str_replace(',', ',<br>', $row->primary_reason()); })
            ->addColumn('area_of_advice', function($row){ return str_replace(',', ',<br>', $row->service_offered()); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->editColumn("type", function($row){ return ucwords($row->type); })
            ->addColumn('auction_time', function($row) use ($system){
                return Carbon::parse($row->start_time)->format($system->date_format. ' h:i A') . ' <br>To<br> ' . Carbon::parse($row->end_time)->format($system->date_format. ' h:i A');
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
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('auction.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                
                if($type == "archive"){
                    if(AccessController::checkAccess("auction_delete")){
                        $li .= '<a href="'.route('auction.delete',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                    if(AccessController::checkAccess("auction_restore")){
                        $li .= '<a href="'.route('auction.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fas fa-redo fa-lg" title="Restore" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("auction_update")){
                        $li .= '<a href="'.route('auction.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                    }
                    if(AccessController::checkAccess("auction_archive")){
                        $li .= '<a href="'.route('auction.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }
                return $li;
            })   
            ->rawColumns(['action', 'status', 'question', "area_of_advice", "service_offer", "primary_reason", "auction_time"])
            ->make(true);
    }

    /**
     * Get Table Column List
     */
    private function getAcceptColumns(){
        $columns = ['#', "advisor", 'ip', 'activity', "time"];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getAcceptDataTableColumns(){
        $columns = ['index', "advisor", 'ip', 'activity', "time"];
        return $columns;
    }

    /**
     * Show Accept Auction Condition List
     */
    public function acceptConditionList(Request $request){        
        if( $request->ajax() ){
            return $this->getActivityDataTable($request);
        }
        
        $params = [
            'nav'               => 'auction',
            'subNav'            => 'auction.accept_list',
            'tableColumns'      => $this->getAcceptColumns(),
            'dataTableColumns'  => $this->getAcceptDataTableColumns(),
            'dataTableUrl'      => Null,
            
            'pageTitle'         => 'Accept Terms and Conditions',
            'tableStyleClass'   => 'bg-success',
        ];
        return view('backEnd.table', $params);
    }

    protected function getActivityDataTable($request){
        $data = ActivityLog::where("activity", "like", "Accept auction's terms and condition%")->get();
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn("advisor", function($row){
                return ($row->advisor->first_name ?? "N/A") .' '. ($row->advisor->last_name ?? "");
            })
            ->addColumn("time", function($row) use($system){
                return Carbon::parse($row->created_at)->format($system->date_format. ' h:i A');
            })
            
            ->make(true);
    }
}
