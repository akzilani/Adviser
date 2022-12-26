<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Profession;
use App\SubscriptionPlan;
use App\SubscriptionPlanOptions;
use App\System;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', "profession", 'profile_star', 'price', "office_manager", 'options', 'publication_status','created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', "profession", 'profile_listing_star', 'price', "office_manager", 'options', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new SubscriptionPlan();
    }

    /**
     * Show SubscriptionPlan List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "View Subscription Plan Table");
        $params = [
            'nav'               => 'subscription',
            'subNav'            => 'subscription.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess('subscription_create') ? route('subscription.create') : false,
            'pageTitle'         => 'Subscription List',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-lg"
        ];
        return view('backEnd.subscription.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Subscription Plan",
            "professions"=> Profession::where("publication_status", true)->get(),
            "form_url"  => route('subscription.create'),
        ]; 
        //$this->saveActivity($request, "Create Subscription Plan Page Open");
        return view('backEnd.subscription.create', $params)->render();
    }

    /**
     * Store Subscription Information
     */
    public function store(Request $request){
        
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'name'          => ['required','string','min:2', 'max:100'],
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Subscription information added successfully';
                $this->saveActivity($request, "Add New Subscription Plan");
            }else{
                $message = 'Subscription information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Subscription Plan", $data);
            }
            $data->name = $request->name;   
            $data->profession_id = $request->profession_id;   
            $data->profile_listing_star = $request->profile_listing_star;
            $data->max_advisor = $request->max_advisor;
            $data->office_manager = $request->office_manager;
            // $data->auction_room_access = $request->auction_room_access;
            // $data->qualified_leads = $request->qualified_leads;
            // $data->per_lead_tbc = $request->per_lead_tbc;
            // $data->account_manager = $request->account_manager;
            // $data->max_qualified_leads_per_month = $request->max_qualified_leads_per_month;
            $data-> price  = $request-> price ;
            $data->duration_type = $request->duration_type;
            $data->charge_type = $request->charge_type;
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->savePlanOPions($data->id, $request);
            DB::commit();
            $this->success($message);
        }catch(Exception $e){
            DB::rollback();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Plan Options
     */
    public function savePlanOPions($plan_id, $request){
        SubscriptionPlanOptions::where('subscription_plan_id', $plan_id)->delete();
        for($i = 0; $i < count($request->key); $i++){
            $plan_option = new SubscriptionPlanOptions();
            $plan_option->subscription_plan_id = $plan_id;
            $plan_option->key       = $request->key[$i];
            $plan_option->status     = $request->status[$i];
            $plan_option->text      = $request->text[$i];
            $plan_option->position  = $request->position[$i];
            $plan_option->save();
        }
    }

    /**
     * Edit Subscription Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Subscription Plan",
            "form_url"  => route('subscription.create'),
            "professions"=> Profession::where("publication_status", true)->get(),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Subscription Plan Page Open");
        return view('backEnd.subscription.create', $params)->render();
    }


    /**
     * Make the selected Subscription Plan As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Subscription Plan");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Subscription Plan As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Subscription plan restored successfully');
            $this->saveActivity($request, "Restore Subscription Plan");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Subscription Plan List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        
        $params = [
            'nav'               => 'subscription' ,
            'subNav'            => 'subscription.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Subscription Plan Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.subscription.table', $params);
    }

    /**
     * Get Subscription Plan DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'ASC')->get();
        }
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })            
            ->editColumn('price', function($row) use($system) { return $system->currency_symbol . $row->price .' ' . $row->duration_type .' - '. $row->charge_type;  })
            ->editColumn('office_manager', function($row) {
                $text =  $row->office_manager == 1 ? "Yes" : "No";  
                $text .= "<br> Allow Max Advisor: " . $row->max_advisor;
                return $text;
            })
            ->addColumn('options', function($row){
                $options = "";
                foreach($row->subscription_plan_options as $option){
                    $options .= $option->text . '<br>';
                }
                return $options;
            })
            ->addColumn("profession", function($row){ return $row->profession->name ?? "N/A"; })
            ->addColumn('action', function($row) use($type){   
                $li = "";
                if(AccessController::checkAccess("subscribePostcode_delete")){
                    $li = '<a href="'.route('subscription.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("subscribePostcode_delete")){
                        $li .= '<a href="'.route('subscription.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("subscribePostcode_delete")){
                        $li .= '<a href="'.route('subscription.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })  
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })          
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status', 'options', "office_manager" ])
            ->make(true);
    }

    
}
