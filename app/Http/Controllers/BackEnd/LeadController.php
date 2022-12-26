<?php

namespace App\Http\Controllers\BackEnd;

use App\Auction;
use App\Events\LeadAssign;
use App\Events\LeadInvitation;
use App\FundSize;
use App\Http\Controllers\Controller;
use App\Leads;
use App\PrimaryReason;
use App\Profession;
use App\ServiceOffer;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class LeadController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'type', 'date', 'name', 'email', 'phone', 'post_code', 'assigned_advisor', "choose_advisor",'fund_size', 'area_of_advice', 'question', 'communication_type', "lead_status", 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'type', 'date', 'name', 'email', 'phone', 'post_code', 'advisor', "choose_advisor",'fund_size', 'area_of_advice', 'question', 'communication_type', "lead_status", 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Status
     */
    public static function getLeadStatus(){
        return [
            "new"           => "New",
            "tried_to_call" => "Tried to call",
            "no_contact"    => "No Contact",
            "not Interested"=> "Not Interested",
            "not_qualified" => "Not Qualified",
            "lead_rejected" => "Lead Rejected",
            "second_call_or_appointment" => "Second call or appointment",
            "re-schedule_success"   => "Re-schedule Success",
            "re-schedule_no_success"=> "Re-schedule No Success",
            "client"        => "Client",
        ];
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Leads();
    }

    /**
     * Show lead List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        $params = [
            'nav'               => 'lead',
            'subNav'            => 'lead.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("lead_create") ? route('lead.create') : false,
            'pageTitle'         => 'Lead List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Show Deleted / Archive lead List 
     */
    public function deletedList(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable("archive");
        }
        
        $params = [
            'nav'               => 'lead',
            'subNav'            => 'lead.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Deleted Lead List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Show Search Local lead List 
     */
    public function searchLocally(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable('search_locally');
        }
        
        $params = [
            'nav'               => 'lead',
            'subNav'            => 'lead.search_locally',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("lead_create") ? route('lead.create') : false, 
            'pageTitle'         => 'Search Local Lead List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Show Match Me lead List 
     */
    public function matchMe(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable('match_me');
        }
        
        $params = [
            'nav'               => 'lead',
            'subNav'            => 'lead.match_me',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('lead.create'),
            'pageTitle'         => 'Match Me Lead List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Lead",
            "form_url"  => route('lead.create'),
            'service_offer' => ServiceOffer::where('publication_status', 1)->orderBy('position','ASC')->get(),
            'advisors'  => User::all(),
            "fund_sizes"=> FundSize::where('publication_status', 1)->orderBy("min_fund", "ASC")->get(),
            "status"    => self::getLeadStatus(),
        ]; 
        //$this->saveActivity($request, "Create lead page open"); 
        return view('backEnd.lead.create', $params)->render();
    }

    /**
     * Store lead Information
     */
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $assign_lead_mail = false;
            $choosen_lead_mail = false;
            $invite_lead_mail = false;
            $validator = Validator::make($request->all(),[
                "advisor_id"            =>['nullable','numeric','min:1'],
                "fund_size_id"          =>['required','numeric','min:1'],
                'name'                  => ['required','string', 'min:2', 'max:191'],
                'last_name'             => ['nullable','string', 'min:1', 'max:191'],
                'email'                 => ['required','email', 'min:2', 'max:191'],
                'phone'                 => ['required','string', 'min:11', 'max:13'],
                'post_code'             => ['required','string', 'min:4', 'max:8'],
                'question'              => ['required','string', 'min:2', 'max:2500'],
                'service_offer_id.*'    => ['nullable','numeric'],
                'communication_type'    => ['nullable','string', 'min:2', 'max:191'],
                'publication_status'    => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $invite_lead_mail = true;
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Lead information added successfully';
                $this->saveActivity($request, "New lead in ".$request->post_code." created"); 
            }else{
                $message = 'Lead information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Lead ".$request->post_code." updated"); 
            }

            if( $data->advisor_id != $request->advisor_id ){
                $assign_lead_mail = true;
            }
            if( empty($data->invite_advisors) ){
                $data->invite_advisors = [];
            }
            if( isset($request->invite_advisors) && !in_array($request->invite_advisors, $data->invite_advisors)){
                $choosen_lead_mail = true;
            }
           
            $data->advisor_id       = $request->advisor_id;            
            $data->fund_size_id     = $request->fund_size_id;            
            $data->name             = $request->name;                         
            $data->last_name        = $request->last_name;                         
            $data->email            = $request->email;                        
            $data->phone            = $request->phone;                        
            $data->post_code        = $request->post_code;                        
            $data->question         = $request->question;                        
            $data->service_offer_id = $request->service_offer_id;                        
            $data->date             = $request->date;                        
            $data->communication_type = $request->communication_type;                      
            $data->publication_status= $request->publication_status;
            $data->status           = $request->status;
            $data->invite_advisors  = (array)$request->invite_advisors; // invite_advisors => Choose Advisor
            if( !empty($request->invite_advisors) ){
                $data->type = "search local";
            }else{
                $data->type = "match me";
            }
            $data->save();

            if($assign_lead_mail){           
                event(new LeadAssign($data, "match me"));
            }
            if($choosen_lead_mail){
                event(new LeadAssign($data, "search local"));
            }

            if($invite_lead_mail){
                event(new LeadInvitation($data));
            }
            
            DB::commit();
            $this->success($message);
        }catch(Exception $e){
            DB::rollBack();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit lead Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Lead",
            "form_url"  => route('lead.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            'service_offer' => ServiceOffer::where('publication_status', 1)->orderBy('position','ASC')->get(),
            'advisors' => User::all(),
            "fund_sizes" => FundSize::where('publication_status', 1)->orderBy("min_fund", "ASC")->get(),
            "status"    => self::getLeadStatus(),
        ];
        //$this->saveActivity($request, "Edit lead page open"); 
        return view('backEnd.lead.create', $params)->render();
    }


    /**
     * Make the selected lead As Archive
     */
    public function archive(Request $request,$id){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $datalead = Leads::find($id);
            $postcodevalue = $datalead->post_code;
            $data->delete();
           // $data = $this->getModel();
            $this->success('Archive deleted successfully');

            $this->saveActivity($request, "Lead ".$postcodevalue." deleted");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected lead As Archive
     */
    public function delete(Request $request, $id){
        try{
            $datalead = $this->getModel()->withTrashed()->find($id);
            $postcodevalue = $datalead->post_code;
            $datalead->forceDelete();           
            $this->success('Permanent deleted successfully');
            $this->saveActivity($request, "Lead ".$postcodevalue." deleted permanently");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected lead As Active from Archive
     */
    public function restore(Request $request, $id){
        try{
            $data = $this->getModel()->withTrashed()->find($id);
            $data->restore();
            $this->success('Lead restored successfully');
            $this->saveActivity($request, "Lead ".$request->post_code." restored"); 
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive LeadList
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        
        $params = [
            'nav'               => 'lead' ,
            'subNav'            => 'lead.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Lead Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.lead.table', $params);
    }

    /**
     * Get lead DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('date', 'DESC')->orderBy('id','DESC')->get();
        }
        elseif($type == "match_me"){
            $data = $this->getModel()->where('type', 'match me')->orderBy('date', 'DESC')->orderBy('id','DESC')->get();
        }
        elseif($type == "search_locally"){
            $data = $this->getModel()->where('type', 'search local')->orderBy('date', 'DESC')->orderBy('id','DESC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->get();
        }
        $system = System::first();
        $lead_status_arr = self::getLeadStatus();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('advisor', function($row){ return ucwords(isset($row->advisor->first_name) ? ($row->advisor->first_name . ' ' . $row->advisor->last_name) : "N/A"); })
            ->addColumn('choose_advisor', function($row){ return ucwords($row->choose_advisor()); })
            ->addColumn('name', function($row){ return ucwords($row->name . ' '. $row->last_name); })
            ->addColumn('service_offer', function($row){ return isset($row->service_offer->name) ? ($row->service_offer->name) : "N/A"; })
            ->addColumn('question', function($row){ return wordwrap($row->question ?? "", "60", "<br>"); })
            ->addColumn('action', function($row) use($type){  
                $li = "";
                
                if($type == 'archive'){
                    if(AccessController::checkAccess("lead_restore")){
                        $li .= '<a href="'.route('lead.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                    if(AccessController::checkAccess("lead_permanent_delete")){
                        $li .= '<a href="'.route('lead.delete',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Permanent Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("lead_update")){
                        $li = '<a href="'.route('lead.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                    }  
                    if(AccessController::checkAccess("lead_assign_auction") && empty($row->auction) && $type != 'archive'){
                        $li .= '<a href="'.route('lead.assign_into_auction',[$row->id]).'" class="ajax-click-page btn btn-sm btn-warning" title="Assign to Auction" > <span class="fas fa-gavel"></span> </a> ';
                    }
                    if(AccessController::checkAccess("lead_delete")){
                        $li .= '<a href="'.route('lead.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }
                
                return $li;
            })   
            ->addColumn('fund_size', function($row){ return $row->fund_size->name ?? "N/A"; })         
            ->addColumn('area_of_advice', function($row){ return $row->service_offered(); })         
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->editColumn("type", function($row){ return ucwords($row->type); })
            ->addColumn('date', function($row) use ($system){
                return Carbon::parse($row->date)->format($system->date_format);
            })
            ->addColumn("lead_status", function($row) use($lead_status_arr){
                return $lead_status_arr[$row->status] ?? "N/A";
            })
            ->rawColumns(['action', 'publication_status', 'question' ])
            ->make(true);
    }

    /**
     * Assign lead into Auction
     */
    public function assignIntoAuction(Request $request){
        try{
            DB::beginTransaction();
            $leads = Leads::find($request->lead_id);
            $fund_size = $leads->fund_size ?? FundSize::first();

            $auction = new Auction();
            $auction->lead_id          = $leads->id;
            $auction->fund_size_id     = $fund_size->id;
            $auction->post_code        = $leads->post_code;
            $auction->communication_type= $leads->communication_type;
            $auction->service_offer_id = $leads->service_offer_id; 
            $auction->start_time       = now()->format('Y-m-d H:i');                   
            $auction->end_time         = now()->addHours(3)->format('Y-m-d H:i');                   
            $auction->question         = $leads->question;                       
            $auction->type             = $leads->type; 
            $auction->status           = "not_started";                       
            $auction->save();

            $this->saveActivity($request, "Assign lead into Auction", $leads);
            $params = [
                "title"     => "Edit Auction",
                "form_url"  => route('auction.create',[$auction->lead_id]),
                "data"      => $auction,
                "reasons"       => PrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
                'service_offer' => ServiceOffer::where('publication_status', 1)->get(),
                "fund_sizes"    => FundSize::where('publication_status', 1)->get(),
                "professions"   => Profession::where("publication_status", true)->get(),
                "mail_send"     => 1,
            ];
            DB::commit();
            return view('backEnd.auction.create', $params)->render();
        }catch(Exception $e){
            return $this->getError($e);
        }
    }

    
}
