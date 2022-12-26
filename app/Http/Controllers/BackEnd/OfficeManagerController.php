<?php

namespace App\Http\Controllers\BackEnd;

use App\AdvisorBillingInfo;
use App\AdvisorCompliance;
use App\AdvisorQuestion;
use App\Events\Subscribe;
use App\Interview;
use App\Testimonial;
use App\Http\Controllers\Controller;
use App\SubscriptionPlan;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class OfficeManagerController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        return ['#', 'office_manager_name', 'email', 'phone', 'post_code', "subscribed", 'created_by', 'updated_by', 'action'];
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        return ['index', 'office_manager_name', 'email', 'phone', 'post_code', "subscribed", 'created_by', 'updated_by', 'action'];
    }

    /**
     * Get Table Column2 List
     */
    private function getColumns2(){
        return ['#', 'office_manager_name', 'email', 'phone', 'post_code', "subscribed", 'created_by', 'updated_by', 'action'];
    }

    /**
     * Get DataTable Column2 List
     */
    private function getDataTableColumns2(){
        return ['index', 'office_manager_name', 'email', 'phone', 'post_code', "subscribed", 'created_by', 'updated_by', 'action'];
    }


    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new User();
    }

    /**
     * Show Office Manager List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        
        $params = [
            'nav'               => 'office_manager',
            'subNav'            => 'list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'tableColumns2'      => $this->getColumns2(),
            'dataTableColumns2'  => $this->getDataTableColumns2(),
            'dataTableUrl'      => URL::current().'?subscribe=0',
            'dataTableUrl2'     => URL::current().'?subscribe=1',
            'create'            => AccessController::checkAccess('office_manager_create') ? route('office_manager.create') : false,
            'pageTitle'         => 'New Office Manager List',
            'pageTitle2'        => 'Subscribed Office Manager List',
            'tableStyleClass'   => 'bg-success',
            'tableStyleClass2'  => 'bg-primary',
            'modalSizeClass'    => "modal-lg",
        ];
        return view('backEnd.advisor.table', $params);
        
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            'nav'               => 'office_manager',
            'subNav'            => 'create',
            "title"     => "Create Office Manager",
            "form_url"  => route('office_manager.create'),
            "subscription_plans" => SubscriptionPlan::where("office_manager", true)->get(),
            "edit"      => false,
        ];
        //$this->saveActivity($request, "Create Office Manager page open"); 
        return view('backEnd.office-manager.create', $params)->render();
    }

    /**
     * Store Office Manager Information
     */
    public function store(Request $request){
        try{ 
            $validator_arr = [
                "first_name"        => ['required','string', "min:2"],
                "last_name"         => ['nullable','string','min:1'],
                'email'             => ['required','email', 'min:2', 'max:191'],
                "password"          => ["required", "min:3", "max:20"],
                'phone'             => ['required','string', 'min:11', 'max:13'],
                'address_line_one'  => ['required','string', 'min:2', 'max:191'],
                'address_line_two'  => ['nullable','string'],
                'town'              => ['nullable','string'],
                'country'           => ['required','string', 'min:2', 'max:191'],
                'post_code'         => ['required', "string", "min:4", "max:8"],

                "subscription_plan_id"              => ['required','numeric'],
                "terms_and_condition_agree_date"    =>['required', "date"],

                "profile_name"          => ['required', "string", "min:2", "max:191"],
                "firm_fca_number"       => ['nullable', "string", "min:2", "max:191"],
                "firm_website_address"  => ['nullable', "string", "min:2", "max:191"],
                "linkedin_id"           => ['nullable', "string", "min:2", "max:191"],
                "profile_details"       => ['nullable', "string", "min:2", "max:191"],
                "profile_name"          => ['nullable', "string", "min:2", "max:191"],

                "contact_name"              => ['required', "string", "min:2", "max:191"],
                "billing_address_line_one"  => ['required', "string", "min:2", "max:191"],
                "billing_address_line_two"  => ['nullable', "string", "min:2", "max:191"],
                "billing_company_name"      => ['nullable', "string", "min:2", "max:191"],
                "billing_company_fca_number"=> ['nullable', "string", "min:2", "max:191"],
                "billing_town"              => ['nullable', "string", "min:2", "max:191"],
                "billing_country"           => ['nullable', "string", "min:2", "max:191"],
                "billing_post_code"         => ['nullable', "string", "min:2", "max:191"]
            ];

            if( $request->id == 0 ){
                $validator = Validator::make($request->all(), $validator_arr);
                if($validator->fails()){
                    return back()->withErrors($validator->errors())->withInput()->with("error", $this->getValidationError($validator));
                }               
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Office Manager information added successfully';
               // $this->saveActivity($request, "Created new office manager"); 
            }else{
                $validator_arr["password"] = ["nullable", "min:3", "max:20"];
                $validator = Validator::make($request->all(), $validator_arr);
                if($validator->fails()){
                    return back()->withErrors($validator->errors())->withInput()->with("error", $this->getValidationError($validator));
                }
                $message = 'Office Manager information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
               // $this->saveActivity($request, "Update Office Manager info", $data); 
               
            //   new added 23_1-_2022
            
                $data= User::find($request->id);
                $first_name = $data->first_name;
                $last_name = $data->last_name;
                $email = $data->email;
                $password = $data->password;
                $phone = $data->phone;
                $address_line_one = $data->address_line_one;
                $address_line_two = $data->address_line_two;
                $town = $data->town;
                $country = $data->country;
                $post_code = $data->post_code;
                $terms_and_condition_agree_date = $data->terms_and_condition_agree_date;
                $subscribeplan = $data->subscription_plan_id;
                $no_subscrive_account = $data->no_of_subscription_accounts;

                $data->first_name = $request->first_name;
                $data->last_name = $request->last_name;
                $data->email = $request->email;
                $data->password = $request->password;
                $data->phone = $request->phone;
                $data->address_line_one = $request->address_line_one;
                $data->address_line_two = $request->address_line_two;
                $data->town = $request->town;
                $data->country = $request->country;
                $data->post_code = $request->post_code;
                $data->terms_and_condition_agree_date = $request->terms_and_condition_agree_date;
                $data->save();


                $name = $first_name .' '. $last_name;
                
                if($subscribeplan != $request->subscription_plan_id){
                    $msg= $name ." Subscription Plan updated ";
                    $this->saveActivity($request , $msg);
                }
                
                if($no_subscrive_account != $request->no_of_subscription_accounts){
                    $msg= $name ." Number of Subscription Accounts updated ";
                    $this->saveActivity($request , $msg);
                }

                if($first_name != $request->first_name){
                    $msg= $name ." advisor First Name updated ";
                    $this->saveActivity($request , $msg);
                }
                if($last_name != $request->last_name){
                    $msg= $name ." advisor Last Name updated ";
                    $this->saveActivity($request , $msg);
                }

                if($email != $request->email){
                    $msg= $name ." advisor Email updated ";
                    $this->saveActivity($request , $msg);
                }

                if($password != $request->password){
                    $msg= $name ." advisor Password updated ";
                    $this->saveActivity($request , $msg);
                }

                if($phone != $request->phone){
                    $msg= $name ." advisor Phone updated ";
                    $this->saveActivity($request , $msg);
                }

                if($address_line_one != $request->address_line_one){
                    $msg= $name ." advisor address line one updated ";
                    $this->saveActivity($request , $msg);
                }

                if($address_line_two != $request->address_line_two){
                    $msg= $name ." advisor address line two updated ";
                    $this->saveActivity($request , $msg);
                }

                if($town != $request->town){
                    $msg= $name ." advisor Town updated ";
                    $this->saveActivity($request , $msg);
                }

                if($country != $request->country){
                    $msg= $name ." advisor County updated ";
                    $this->saveActivity($request , $msg);
                }

                if($post_code != $request->post_code){
                    $msg= $name ." advisor Post Code updated ";
                    $this->saveActivity($request , $msg);
                }
                if($terms_and_condition_agree_date != $request->terms_and_condition_agree_date){
                    $msg= $name ." advisor Terms and Condition Agree Date Code updated ";
                    $this->saveActivity($request , $msg);
                }
            }
            $advisor = $this->saveOfficeManagerInfo($data, $request);
            (new AdvisorController())->saveFirmInfo($request, $advisor);
            (new AdvisorController())->saveBillingInfo($request, $advisor);
            
            return back()->with("success", $message);
        }catch(Exception $e){
            return back()->with("error", $this->getError($e));
        }
        
    }

    /**
     * Save OfficeManager Info
     */
    protected function saveOfficeManagerInfo($data, $request){
        $data->first_name = $request->first_name;            
        $data->last_name = $request->last_name;            
        $data->email = $request->email;
        $data->phone = $request->phone;
        
        if(!empty($request->password)){
            $data->password =  bcrypt($request->password);
        }
        $data->address_line_one = $request->address_line_one;
        $data->address_line_two = $request->address_line_two;
        $data->post_code = $request->post_code;
        $data->town = $request->town;
        $data->country = $request->country;
        $data->subscription_plan_id = $request->subscription_plan_id;   
        $data->terms_and_condition_agree_date = $request->terms_and_condition_agree_date;
        $data->no_of_subscription_accounts = $request->no_of_subscription_accounts;
        $data->is_live = false;
        $data->save();
        return $data;
    }

    /**
     * Subscribe
     */
    public function subscribe(Request $request){
        try{
            $advisor = $this->getModel()->find($request->id);
            $advisor->subscribe = $request->subscribe;
            $advisor->save();
            if($request->subscribe){
                event(new Subscribe($advisor));
            }
            $this->saveActivity($request, "Office Manager subscribed status changed", $advisor);
            $this->success('Office Manager subscribed status changed successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Office Manager Info
     */
    public function edit(Request $request){
        $params = [
            'nav'               => 'office_manager',
            'subNav'            => 'create',
            "title"     => "Create Office Manager",
            "form_url"  => route('office_manager.create'),
            "subscription_plans" => SubscriptionPlan::where("office_manager", true)->get(),
            "edit"      => true,
            "data"      => User::find($request->id),
        ];
        //$this->saveActivity($request, "Edit Office Manager page open"); 
        return view('backEnd.office-manager.create', $params)->render();
    }

    public function viewBilingInfo(Request $request){
        $office_manager = User::find($request->id);
        $params = [
            "data"      => $office_manager->billing_info,
        ];
        //$this->saveActivity($request, "View Advisor Billing Info");
        return view('backEnd.office-manager.view-billing', $params)->render();
    }


    /**
     * Make the selected Office Manager As Archive
     */
    public function archive(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Archive deleted successfully');
            $this->saveActivity($request, "Delete Office Manager"); 
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Office Manager As Active from Archive
     */
    public function restore(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Office Manager restored successfully');
            $this->saveActivity($request, "Office Manager restored", $data);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Office ManagerList
     */
    public function archiveList(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request, 'archive');
        }
        $params = [
            'nav'               => 'office_manager' ,
            'subNav'            => 'archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Office Manager Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }
    /**
     * Permanently Delete
     */
    public function delete(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            AdvisorBillingInfo::where('advisor_id', $data->id)->delete();
            Testimonial::where('advisor_id', $data->id)->forceDelete();
            AdvisorQuestion::where('advisor_id', $data->id)->forceDelete();
            AdvisorCompliance::where('advisor_id', $data->id)->delete();
            Interview::where('advisor_id', $data->id)->delete();

            $this->saveActivity($request, "Office manager deleted", $data);
            $data->forceDelete();
            $this->success(' Office Manager deleted successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }


    /**
     * Get Office Manager DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($request, $type = 'list'){
        $subscribe = true;
        if( isset($request->subscribe) ){
            $subscribe = $request->subscribe;
        }

        $data = $this->getModel()->join("subscription_plans", "subscription_plans.id", "=", "advisors.subscription_plan_id")
            ->where("subscription_plans.office_manager", true)
            ->where("advisors.office_manager_id", null);

        if( $type == "list" ){
            $data = $data->where('subscribe', $subscribe);
        }else{
            $data = $data->onlyTrashed();
        }

        $data = $data->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->select("advisors.*")->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('office_manager_name', function($row){ return ($row->first_name. ' '. $row->last_name ); })
            ->addColumn('action', function($row) use($type){  
                $li = "";
                if($type == 'list'){
                    $li = '<a href="'.route('advisor.view',['id' => $row->id]).'" class="btn btn-sm btn-primary" title="Office Manager Profile" target="_blank"> <span class="fa fa-user fa-lg"></span> Office Manager Admin</a> '; 
                }
                if(AccessController::checkAccess("office_manager_update")){
                    $li .= '<a href="'.route('office_manager.edit',['id' => $row->id]).'" class="btn btn-sm btn-warning" title="Edit" > <span class="fa fa-edit fa-lg"></span> Edit</a> ';
                }
                $li .= '<a href="'.route('office_manager.view_billing',['id' => $row->id]).'" class="btn btn-sm btn-info ajax-click-page" title="View Billing Info" > <span class="fa fa-eye fa-lg"></span> Billing Info</a> ';
                if(AccessController::checkAccess("office_manager_update")){
                    $li .= '<a href="'.route('advisor.change_password',['id' => $row->id]).'" class="btn btn-sm btn-dark ajax-click-page" title="Edit" > <span class="fa fa-edit fa-lg"></span>Change Password</a> ';
                }
                if(empty($row->email_verified_at)){
                    $li .= '<a href="'.route('advisor.make_email_verify',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-success" title="Make Email Verify" > <i class="far fa-check-square fa-lg"></i> Manually Verify</a> ';
                    $li .= '<a href="'.route('advisor.send_email_verification',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-warning" title="Send Verification Email" > <span class="far fa-envelope fa-lg"></span> Send verification email </a> ';
                }
                
                if($type == 'list'){
                    if(AccessController::checkAccess("office_manager_delete")){
                        $li .= '<a href="'.route('office_manager.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash fa-lg" title="Delete" ></span> Delete</a> ';
                    }
                }else{
                    if(AccessController::checkAccess("office_manager_restore")){
                        $li .= '<a href="'.route('office_manager.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo fa-lg"></i> Restore</a> ';
                    }
                    if(AccessController::checkAccess("office_manager_delete")){
                        $li .= '<a href="'.route('office_manager.delete',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash fa-lg" title="Delete" ></span> Permanent Delete</a> ';
                    }
                }
                return $li;
            })    
            ->editColumn('subscribed', function($row){
                if( !$row->subscribe ){
                    return '<a href="'.route('office_manager.subscribe',[$row->id, 1]).'" class="ajax-click btn btn-sm btn-warning" title="Unsubscribed" >Unsubscribed</a> '; 
                }else{
                    return '<a href="'.route('office_manager.subscribe',[$row->id, 0]).'" class="ajax-click btn btn-sm btn-success" title="Subscribed" >Subscribed</a> '; 
                }                
            })       
            ->addcolumn('profile_name', function($row){ return $row->firm_details->profile_name; })
            ->editColumn('status', function($row){ return $this->getStatus($row->status); })
            ->addColumn("email_verify", function($row){ return !empty($row->email_verified_at) ? $this->getStatus('verified') : $this->getStatus('not_verified') ; })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status', 'email_verify', "subscribed"])
            ->make(true);
    }
    
}
