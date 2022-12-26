<?php

namespace App\Http\Controllers\FrontEnd;

use App\FundSize;
use App\Http\Controllers\BackEnd\LeadController as BackEndLeadController;
use App\Http\Controllers\Controller;
use App\Leads;
use App\ServiceOffer;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class LeadController extends Controller
{
    /**
     * Lead Status
     */
    protected $lead_status_arr = [];

    function __construct()
    {
        $this->lead_status_arr = BackEndLeadController::getLeadStatus();
    }

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'type', 'post_code', 'question', 'communication_type', "fund_size", 'area_of_advice', "lead_status",  'publication_status',  'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'type', 'post_code', 'question', 'communication_type', "fund_size", 'area_of_advice', "lead_status", 'publication_status', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return Leads::where('advisor_id', Auth::user()->id)->orderBy('date', "DESC");
        // return Leads::orderBy('date', "DESC");
    }

    /**
     * Show lead List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Advisor Lead Table Show");
        $params = [
            'nav'               => 'leads',
            'subNav'            => 'leads.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => false,
            'pageTitle'         => 'Lead List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg",
            'table_responsive'  => "table-responsive",
            
        ];
        return view('frontEnd.table', $params);
    }

    /**
     * View Leads Details
     */
    public function view(Request $request){
        $lead = Leads::where('id',$request->id)->first();
        if( empty($lead) ){
            return "No lead found";
        }
        return view('frontEnd.advisor.lead.view', ['data' => $lead]);
    }

    /**
     * Edit Lead Status
     */
    public function Edit(Request $request){
        $lead = Leads::where('id',$request->id)->first();
        if( empty($lead) ){
            return "No lead found";
        }
        $param = [
            "title"     => "Edit Lead Information",
            "form_url"  => route("advisor.leads.edit",[$lead->id]),
            "data"      => $lead,
            "lead_status" => $this->lead_status_arr,
        ];
        $this->saveActivity($request, "Edit Advisor Lead Page Open");
        return view('frontEnd.advisor.lead.edit', $param);
    }

    /**
     * Update Lead Information
     */
    public function store(Request $request){
        $lead = Leads::where('id',$request->id)->first();
        $lead->status  = $request->status;
        $lead->save();
        $this->saveActivity($request, "Update Lead Status", $lead);
        $this->success("Lead Status Updated Successfully");
        return $this->output();
    }


    /**
     * Get lead DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->get();
        }
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('question', function($row){ return wordwrap($row->question ?? "", "60", "<br>"); })
            ->editColumn('type', function($row){ return ucwords($row->type); })
            ->addColumn('fund_size', function($row){ return ucfirst($row->fund_size->name ?? "N/A"); })
            ->addColumn('area_of_advice', function($row){ return ucfirst($row->service_offered() ?? ""); })
            ->addColumn('action', function($row){                
                $li = '<a href="'.route('advisor.leads.view',[$row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="View" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('advisor.leads.edit',[$row->id]).'" class="ajax-click-page btn btn-sm btn-warning" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                return $li;
            })            
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->addColumn('date', function($row) use ($system){
                return Carbon::parse($row->date)->format($system->date_format);
            })
            ->addColumn("lead_status", function($row){
                return $this->lead_status_arr[$row->status] ?? "N/A";
            })
            ->rawColumns(['action', 'publication_status', 'question' ])
            ->make(true);
    }

    
}
