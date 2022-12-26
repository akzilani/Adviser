<?php

namespace App\Http\Controllers\BackEnd;

use App\AdvisorBillingInfo;
use App\AdvisorCompliance;
use App\AdvisorQuestion;
use App\AdvisorType;
use App\Events\Subscribe;
use App\FirmDetails;
use App\FundSize;
use App\Http\Components\Classes\Fetchify;
use App\Http\Components\Classes\MatchRating;
use App\Http\Controllers\Controller;
use App\Import\AdvisorListImport;
use App\Interview;
use App\PrimaryReason;
use App\Profession;
use App\PromotionalAdvisor;
use App\ServiceOffer;
use App\SubscribePrimaryReason;
use App\SubscriptionPlan;
use App\System;
use App\Testimonial;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AdvisorController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', "date", "advisor", 'email', 'assign_number', "mobile_number", 'personal_fca_no', 'advisor_type', 'profile_name' ,'primaty_reason', 'area_covered', 'plan', 'subscribed', 'status', "live", 'email_verify', 'action',];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', "date", 'advisor', 'email', 'telephone', "phone", 'personal_fca_number', 'profession', 'profile_name', 'primary_reason', 'area_covered', 'subscription', 'subscribe', 'status', "live", 'email_verify','action'];
        return $columns;
    }



    /**
     * Get Table Column List
     */
    private function getColumns2(){
        $columns = ['#', "date", "advisor", 'email', 'assign_number', "mobile_number", 'personal_fca_no', 'advisor_type', 'profile_name', 'primary_reason', 'area_covered', 'subscribe_area_covered','plan', "non_specific_rating", 'subscribed',  'status', "live", 'email_verify', 'action',];
        return $columns;
    }



    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns2(){
        $columns = ['index', "date", 'advisor', 'email', 'telephone', "phone", 'personal_fca_number', 'profession', 'profile_name', 'primary_reason', 'area_covered', 'subscribe_area_covered','subscription', "non_specific_rating", 'subscribe', 'status', "live", 'email_verify','action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new User();
    }

    /**
     * Show advisor List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request, "list");
        }
        //$this->saveActivity($request, "View Advisor List");
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'tableColumns2'      => $this->getColumns2(),
            'dataTableColumns2'  => $this->getDataTableColumns2(),
            'dataTableUrl'      => URL::current().'?subscribe=0',
            'dataTableUrl2'     => URL::current().'?subscribe=1',
            'create'            => AccessController::checkAccess('advisor_create') ? route('advisor.create') : false,
            'pageTitle'         => 'New Advisors List',
            'pageTitle2'        => 'Subscribed Advisors List',
            'tableStyleClass'   => 'bg-success',
            'tableStyleClass2'  => 'bg-primary',
            'modalSizeClass'    => "modal-lg",
        ];
        return view('backEnd.advisor.table', $params);
    }

    /**
     * Show advisor List  without Archive
     */
    public function missingInfoList(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request, "list", true);
        }
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.missing_info_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'create'            => AccessController::checkAccess('advisor_create') ? route('advisor.create') : false,
            'pageTitle'         => 'Advisors Missing Info List',
            'tableStyleClass'   => 'bg-primary',
            'modalSizeClass'    => "modal-lg",
        ];
        return view('backEnd.advisor.missing-info-table', $params);
    }

    /**
     * Show Deleted advisor List
     */
    public function deletedAdvisorList(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request, "deleted");
        }
        //$this->saveActivity($request, "View Deleted Advisor List");
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.archived_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'pageTitle'         => 'Deleted Advisor List',
            'tableStyleClass'   => 'bg-success',
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Show Filter advisor List
     */
    public function filterAdvisor(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request, "list");
        }

        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Filter Advisor List',
            'tableStyleClass'   => 'bg-success',
            'tableStyleClass2'   => 'bg-primary'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        //$this->saveActivity($request, "Advisor Creation Page Open");
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.create',
            "title"             => "Create Advisor",
            "form_url"          => route('advisor.create'),
            "reasons"           => PrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
            "subscribe_reasons" => SubscribePrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
            "advisor_types"     => AdvisorType::where("publication_status", true)->orderBy("name", "ASC")->get(),
            "subscription_plans"=> SubscriptionPlan::where("office_manager", false)->get(),
            "professions"       => Profession::where("publication_status", true)->orderBy("name", "ASC")->get(),
            "service_offers"    => ServiceOffer::where("publication_status", true)->orderBy("position", "ASC")->get(),
            "fund_sizes"        => FundSize::where("publication_status", true)->orderBy("min_fund", "ASC")->get(),
            "edit"              => false,
        ];
        return view('backEnd.advisor.create', $params);
    }

    /**
     * Store advisor Information
     */
    public function store(Request $request){
        $validator_data = [
            'profession_id'     => ['required','numeric','min:1'],
            "first_name"        => ['required','string','min:2', 'max:100'],
            "last_name"         => ['nullable','string','min:1', 'max:100'],
            "email"             => ['required','email', $request->id == 0 ? 'unique:advisors' : null],
            "password"          => [ $request->id == 0 ? 'required' : 'nullable','string','min:4', 'max:100'],
            "phone"             => ['required','string','min:8', 'max:16'],
            "telephone"         => ['nullable','string','min:8', 'max:16'],
            "personal_fca_number"=>['nullable','string','min:2', 'max:100'],
            "address_line_one"  => ['required','string','min:4', 'max:191'],
            "address_line_two"  => ['nullable','string','min:4', 'max:191'],
            "post_code"         => ['required','string','min:4', 'max:8'],
            "town"              => ['nullable','string','min:2', 'max:100'],
            "country"           => ['required','string','min:2', 'max:100'],
            "subscription_plan_id"=> ['required','numeric','min:1'],
            "fund_size_id"      => ['required','numeric','min:1'],
            "primary_region_id" => ['required','numeric','min:1'],
            "status"            => ["required", "string", "min:4", "max:20"],
            "advisor_type_id.*"   => ["required", "numeric"],
            "service_offered_id.*" => ["required", "numeric"],
            "location_postcode_id.*" => ["required", "numeric"],
        ];
        Validator::make($request->all(), $validator_data, [
            "first_name.min"        => "First name must be at least 2 characters",
            "last_name.min"         => "Last name must be at least 2 characters",
            "email.unique"          => "Error! This email address is already registered",
            "phone.min"             => "Phone number must be at least 8 characters",
            "telephone.min"         => "Telephone number must be at least 8 characters",
            "address_line_one.min"  => "Error! Address line 1 must be at least 4 characters",
            "address_line_two.min"  => "Error! Address line 2 must be at least 4 characters",
            "town.min"              => "Error! Town must be at least 2 characters",
            "post_code.min"         => "Error! Postcode must be at least 4 characters",
            "country.min"           => "Error! County must be at least 2 characters",
            "firm_name.min"         => "Firm name must be at least 2 characters",
            "firm_fca_number.min"   => "Firm FCA number must be at least 2 characters ",

            "firm_website_address.min"  => "Firm website address must be at least 2 characters",
            "personal_fca_number.min"   => "Error! Personal FCA number must be at least 2 characters",
            "linkedin_id.min"           => "Linkedin ID must be at least 2 characters",
        ])->validate();

        try{
            // $fetchify_validate = true;
            // $fetchify_validate_error_message = [];
            // $response =  (new Fetchify())->isValidEmail($request->email);
            // if( !$response["status"] ){
            //     $fetchify_validate = false;
            //     $fetchify_validate_error_message["email"] = "This Email is invalid";
            // }
            // $response =  (new Fetchify())->isValidPhone($request->phone);
            // if( !$response["status"] ){
            //     $fetchify_validate = false;
            //     $fetchify_validate_error_message["phone"] = "This Phone number is invalid";
            // }
            // $response =  (new Fetchify())->isValidPostCode($request->post_code);
            // if( !$response["status"] ){
            //     $fetchify_validate = false;
            //     $fetchify_validate_error_message["post_code"] = "This Postcode is invalid";
            // }
            // if( !$fetchify_validate ){
            //     return back()->withInput()->withErrors($fetchify_validate_error_message);
            // }

            DB::beginTransaction();
            $send_terms_and_condition_email = false;
            if( $request->id == 0 ){
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                //$message = 'Advisor Information added Successfully';
                //$this->saveActivity($request, "Add New Advisor", $data);
                //new activity
                $name = $request->first_name .' '. $request->last_name;
                $message = "Add New Advisor";
                $msg = implode(' ', array($message,$name));
                $this->saveActivity($request, $msg);
            }
            else{
                $message = 'Advisor Information updated Successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
            }

            if( !empty($data->subscription_plan_id) && ($data->subscription_plan_id != $request->subscription_plan_id) ){
                $send_terms_and_condition_email = true;
            }
             //data store for acticity check
             $profession_id   =$data->profession_id;
             $first_name      =$data->first_name;
             $last_name       =$data->last_name;
             $email           =$data->email;
             $phone           =$data->phone;
             $telephone       =$data->telephone;
             $view_telephone_no=$data->view_telephone_no;
             $personal_fca_number=$data->personal_fca_number;
             $fca_status_date =$data->fca_status_date;
             $password        =$data->password;
             $address_line_one=$data->address_line_one;
             $address_line_two=$data->address_line_two;
             $postcode = $data->post_code;
           // $post_code = $data->post_code;
            $town=$data->town;
            $country=$data->country;
            $subscription_plan_id=$data->subscription_plan_id;

            $fund = $data->fund_size_id;
            //$fund_size_id = $data->fund_size_id;
            $primary_region_id=$data->primary_region_id;

            $service      = $data->service_offered_id;
        // $service_offered_id      = $data->service_offered_id;
            $subscribe_primary_region_id=$data->subscribe_primary_region_id;
            $status=$data->status;
            $live  = $data->is_live;
            //$is_live  = $data->is_live;
            $terms_and_condition_agree_date=$data->terms_and_condition_agree_date ;
            $no_of_subscription_accounts=$data->no_of_subscription_accounts;
            $advisor_type_id=$data->advisor_type_id;
            $service_offered_id=$data->service_offered_id;
        // $location_postcode_id = $data->location_postcode_id;
            $location_postcode_id = $data->location_postcode_id;
            $subscribe_location_postcode_id=$data->subscribe_location_postcode_id;
            $latitude=$data->latitude;
            $longitude=$data->longitude;

            $data->profession_id    = $request->profession_id;
            $data->first_name       = $request->first_name;
            $data->last_name        = $request->last_name;
            $data->email            = $request->email;
            $data->phone            = $request->phone;
            $data->telephone        = $request->telephone;
            $data->view_telephone_no= $request->view_telephone_no ?? 0;
            $data->personal_fca_number= $request->personal_fca_number;
            $data->fca_status_date  = $request->fca_status_date;
            $data->password         = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->address_line_one = $request->address_line_one;
            $data->address_line_two = $request->address_line_two;
            $data->post_code        = $request->post_code;
            $data->town             = $request->town;
            $data->country          = $request->country;
            $data->subscription_plan_id= $request->subscription_plan_id;
            $data->fund_size_id     = $request->fund_size_id;
            $data->primary_region_id= $request->primary_region_id;
            $data->subscribe_primary_region_id = $request->subscribe_primary_region_id;
            $data->status           = $request->status;
            $data->is_live          = $request->is_live;
            $data->terms_and_condition_agree_date   = $request->terms_and_condition_agree_date;
            $data->no_of_subscription_accounts      = $request->no_of_subscription_accounts;
            $data->advisor_type_id      = $request->advisor_type_id;
            $data->service_offered_id   = $request->service_offered_id;
            $data->location_postcode_id             = $request->location_postcode_id;
            $data->subscribe_location_postcode_id   = $request->subscribe_location_postcode_id;
            $data->latitude             = $request->latitude;
            $data->longitude            = $request->longitude;
            $data->image                = $this->uploadImage($request, 'image', $this->advisor_image, null, null, $data->image);
            $data->save();


            //New Activity
            $name = $data->first_name .' '. $data->last_name;

            if($request->id != 0){
            if($postcode != $data->post_code){
                $message = "Advisor Postcode updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($profession_id != $data->profession_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " Profession Updated";
                $this->saveActivity($request , $msg);
            }
            if($first_name != $data->first_name)
            {
                $msg= $data->first_name.' '.$data->last_name. " First Name Updated";
                $this->saveActivity($request , $msg);
            }
            if($last_name != $data->last_name)
            {
                $msg= $data->first_name.' '.$data->last_name. " Last Name Updated";
                $this->saveActivity($request , $msg);
            }
            if($email != $data->email)
            {
                $msg= $data->first_name.' '.$data->last_name. " Email Updated";
                $this->saveActivity($request , $msg);
            }
            if($phone != $data->phone)
            {
                $msg= $data->first_name.' '.$data->last_name. " Phone Updated";
                $this->saveActivity($request , $msg);
            }
            if($telephone != $data->telephone)
            {
                $msg= $data->first_name.' '.$data->last_name. " Telephone Updated";
                $this->saveActivity($request , $msg);
            }
            if($view_telephone_no != $data->view_telephone_no)
            {
                $msg= $data->first_name.' '.$data->last_name. " View Assigned Number Updated";
                $this->saveActivity($request , $msg);
            }
            if($personal_fca_number != $data->personal_fca_number)
            {
                $msg= $data->first_name.' '.$data->last_name. " Personal FCA Ref. Number Updated";
                $this->saveActivity($request , $msg);
            }
            if($fca_status_date != $data->fca_status_date)
            {
                $msg= $data->first_name.' '.$data->last_name. " FCA Status Effective Date Updated";
                $this->saveActivity($request , $msg);
            }
            if($password != $data->password)
            {
                $msg= $data->first_name.' '.$data->last_name. " Password Updated";
                $this->saveActivity($request , $msg);
            }
            if($address_line_one != $data->address_line_one)
            {
                $msg= $data->first_name.' '.$data->last_name. " Address line One Updated";
                $this->saveActivity($request , $msg);
            }
            if($address_line_two != $data->address_line_two)
            {
                $msg= $data->first_name.' '.$data->last_name. " Address line Two Updated";
                $this->saveActivity($request , $msg);
            }
            if($town != $data->town)
            {
                $msg= $data->first_name.' '.$data->last_name. " Town Updated";
                $this->saveActivity($request , $msg);
            }
            if($country != $data->country)
            {
                $msg= $data->first_name.' '.$data->last_name. " County Updated";
                $this->saveActivity($request , $msg);
            }
            if($subscription_plan_id != $data->subscription_plan_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " Subscription Plan updated";
                $this->saveActivity($request , $msg);
            }

            if($primary_region_id != $data->primary_region_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " Primary Region  Updated";
                $this->saveActivity($request , $msg);
            }

            if($subscribe_primary_region_id != $data->subscribe_primary_region_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " Subscribe Primary Region Updated";
                $this->saveActivity($request , $msg);
            }

            if($status!= $data->status)
            {
                $msg= $data->first_name.' '.$data->last_name. " Status Updated";
                $this->saveActivity($request , $msg);
            }
            if($fund != $data->fund_size_id){
                $message = "Advisor Fund value updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($service  != $data->service_offered_id){
                $message = "Advisor Areas of advice updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($live != $data->is_live){
                if($data->is_live == 1){
                    $message = "Advisor Account status active";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
                else{
                    $message = "Advisor Account status paused";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
            }
             if($terms_and_condition_agree_date != $data->terms_and_condition_agree_date)
            {
                $msg= $data->first_name.' '.$data->last_name. " Terms and Condition Agree Date Updated";
                $this->saveActivity($request , $msg);
            }
            if($no_of_subscription_accounts != $data->no_of_subscription_accounts)
            {
                $msg= $data->first_name.' '.$data->last_name. " No of Subscription Accounts Region  Updated";
                $this->saveActivity($request , $msg);
            }
            if($advisor_type_id != $data->advisor_type_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " Advisor Type Updated";
                $this->saveActivity($request , $msg);
            }
            // if($service_offered_id != $data->service_offered_id)
            // {
            //     $msg= $data->first_name.' '.$data->last_name. " Service Offered Updated";
            //     $this->saveActivity($request , $msg);
            // }

            if($location_postcode_id != $data->location_postcode_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " Postcode areas covered updated ";
                $this->saveActivity($request , $msg);
            }

            if($subscribe_location_postcode_id != $data->subscribe_location_postcode_id)
            {
                $msg= $data->first_name.' '.$data->last_name. " subscription postcodes updated ";
                $this->saveActivity($request , $msg);
            }
            if($latitude != $data->latitude)
            {
                $msg= $data->first_name.' '.$data->last_name. " latitude Updated";
                $this->saveActivity($request , $msg);
            }
            if($longitude != $data->longitude)
            {
                $msg= $data->first_name.' '.$data->last_name. " longitude Updated";
                $this->saveActivity($request , $msg);
            }


            }

            $this->saveFirmInfo($request, $data);
            $this->saveBillingInfo($request, $data);
            (new MatchRating($data))->handel();
            $this->success($message);
            DB::commit();
            try{
                if($request->id == 0){
                    event(new Registered($data));
                }
                if($send_terms_and_condition_email){
                    event(new Subscribe($data, false));
                }
            }catch(Exception $e){
                // dd( $this->getError($e));
            }
        }catch(Exception $e){
            DB::rollBack();
            return back()->with("error", $this->getError($e))->withInput();
        }


        return back()->with ("success",  $request->id == 0 ? "Advisor Basic Information Added Successfully" : "Advisor Basic Information Updated Successfully");
    }

    /**
     * Save Firm Info
     */
    public function saveFirmInfo($request, $advisor){
       /* $data = $advisor->firm_details;
        if(empty($data)){
            $data = new FirmDetails();
            $data->created_by = $request->created_by;
        }else{
            $data->updated_by = $request->updated_by;
        }
        $data->advisor_id = $advisor->id;
        $data->profile_name = $request->profile_name;
        $data->profile_details = $request->profile_details;
        $data->firm_fca_number = $request->firm_fca_number;
        $data->firm_website_address = $request->firm_website_address;
        $data->linkedin_id = $request->linkedin_id;
        $data->save();
        $this->saveActivity($request, "Save Advisor Firm Info", $data); */

        //New
        $data = $advisor->firm_details;
        if(empty($data)){
                $data = new FirmDetails();
                $data->created_by = $request->created_by;
                $data->advisor_id = $advisor->id;
                $data->profile_name = $request->profile_name;
                $data->profile_details = $request->profile_details;
                $data->firm_fca_number = $request->firm_fca_number;
                // $data->firm_post_code = $request->firm_post_code;
                // $data->firm_address_line_one = $request->firm_address_line_one;
                // $data->firm_address_line_two = $request->firm_address_line_two;
                // $data->firm_town = $request->firm_town;
                // $data->firm_country = $request->firm_country;
                $data->firm_website_address = $request->firm_website_address;
                $data->linkedin_id = $request->linkedin_id;
                $data->save();

                $this->saveActivity($request,"Create new Office Manager");

        }else{
                //store data for activity
                $profile_name = $data->profile_name;
                $profile_details =  $data->profile_details;
                $firm_fca_number = $data->firm_fca_number;
                $firm_website_address = $data->firm_website_address;
                $linkedin_id = $data->linkedin_id;


                $data->advisor_id = $advisor->id;
                $data->profile_name = $request->profile_name;
                $data->profile_details = $request->profile_details;
                $data->firm_fca_number = $request->firm_fca_number;
                // $data->firm_post_code = $request->firm_post_code;
                // $data->firm_address_line_one = $request->firm_address_line_one;
                // $data->firm_address_line_two = $request->firm_address_line_two;
                // $data->firm_town = $request->firm_town;
                // $data->firm_country = $request->firm_country;
                $data->firm_website_address = $request->firm_website_address;
                $data->linkedin_id = $request->linkedin_id;
                $data->updated_by = $request->updated_by;
                $data->save();

                //new Activity
                $name = $advisor->first_name .' '. $advisor->last_name;
                if($profile_name != $data->profile_name || $profile_details != $data->profile_details
                || $firm_fca_number != $data->firm_fca_number || $firm_website_address != $data->firm_website_address
                || $linkedin_id != $data->linkedin_id){

                    $message = "Advisor Firm Info updated";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
                if($profile_name != $data->profile_name){
                    $message = "Advisor profile name updated";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
                if($profile_details != $data->profile_details){
                    $message = "Advisor profile details updated";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
                if($firm_fca_number != $data->firm_fca_number){
                    $message = "Advisor firm fca number updated";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
                if($firm_website_address != $data->firm_website_address){
                    $message = "Advisor firm website address updated";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
                if($linkedin_id != $data->linkedin_id){
                    $message = "Advisor linkedin id updated";
                    $msg = implode(' ', array($name, $message));
                    $this->saveActivity($request, $msg);
                }
        }

    }

    /**
     * Billing Info
     */
    public function saveBillingInfo($request, $advisor){
        /*$data = $advisor->billing_info;
        if(empty($data)){
            $data = new AdvisorBillingInfo();
            $data->created_by = $request->created_by;
        }else{
            $data->updated_by = $request->updated_by;
        }
        $data->advisor_id = $advisor->id;
        $data->contact_name = $request->contact_name ?? "";
        $data->billing_address_line_one = $request->billing_address_line_one;
        $data->billing_address_line_two = $request->billing_address_line_two;
        $data->billing_town = $request->billing_town;
        $data->billing_post_code = $request->billing_post_code;
        $data->billing_country = $request->billing_country;
        $data->billing_company_name = $request->billing_company_name;
        $data->billing_company_fca_number = $request->billing_company_fca_number;
        $data->save();
        $this->saveActivity($request, "Save Advisor Billing Info", $data);*/

        //New
         $data = $advisor->billing_info;
        if(empty($data)){
            $data = new AdvisorBillingInfo();
            $data->created_by = $request->created_by;
            $data->advisor_id = $advisor->id;
            $data->contact_name = $request->contact_name ?? "";
            $data->billing_address_line_one = $request->billing_address_line_one;
            $data->billing_address_line_two = $request->billing_address_line_two;
            $data->billing_town = $request->billing_town;
            $data->billing_post_code = $request->billing_post_code;
            $data->billing_country = $request->billing_country;
            $data->billing_company_name = $request->billing_company_name;
            $data->billing_company_fca_number = $request->billing_company_fca_number;
            $data->save();
            // $name = $advisor->first_name .' '. $advisor->last_name;
            // $message = "Save Advisor Billing Info of";
           //  $msg = implode(' ', array($message,$name));
            //  $this->saveActivity($request,$msg);
        }else{
            //store data for activity
            $contact_name =  $data->contact_name;
            $billing_address_line_one = $data->billing_address_line_one;
            $billing_address_line_two = $data->billing_address_line_two;
            $billing_town = $data->billing_town;
            $billing_post_code = $data->billing_post_code;
            $billing_country = $data->billing_country;
            $billing_company_name = $data->billing_company_name;
            $billing_company_fca_number =  $data->billing_company_fca_number;
            //
            $data->advisor_id = $advisor->id;
            $data->contact_name = $request->contact_name ?? "";
            $data->billing_address_line_one = $request->billing_address_line_one;
            $data->billing_address_line_two = $request->billing_address_line_two;
            $data->billing_town = $request->billing_town;
            $data->billing_post_code = $request->billing_post_code;
            $data->billing_country = $request->billing_country;
            $data->billing_company_name = $request->billing_company_name;
            $data->billing_company_fca_number = $request->billing_company_fca_number;
            $data->updated_by = $request->updated_by;
            $data->save();

            //new Activity
            $name = $advisor->first_name .' '. $advisor->last_name;

            if($contact_name != $data->contact_name || $billing_address_line_one != $data->billing_address_line_one
            || $billing_address_line_two != $data->billing_address_line_two || $billing_town != $data->billing_town
            || $billing_post_code != $data->billing_post_code || $billing_country != $data->billing_country
            || $billing_company_name != $data->billing_company_name || $billing_company_fca_number != $data->billing_company_fca_number){

                // $message = "Advisor Billing Info updated";
                // $msg = implode(' ', array($name, $message));
                // $this->saveActivity($request, $msg);

            }

            if($contact_name != $request->contact_name){
                 $message = " Advisor contact name updated";
                 $msg = implode(' ', array($name, $message));
                 $this->saveActivity($request, $msg);
            }
            if($billing_address_line_one != $data->billing_address_line_one){
                $message = " Advisor billing address line one updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($billing_address_line_two != $data->billing_address_line_two){
                $message = " Advisor billing address line two updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($billing_town != $data->billing_town){
                $message = " Advisor billing town updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($billing_post_code != $data->billing_post_code){
                $message = " Advisor billing post code updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
            if($billing_country != $data->billing_country){
                 $message = " Advisor billing county updated";
                 $msg = implode(' ', array($name, $message));
                 $this->saveActivity($request, $msg);
            }
            if($billing_company_name != $data->billing_company_name){
                 $message = "Advisor billing company name updated";
                 $msg = implode(' ', array($name, $message));
                 $this->saveActivity($request, $msg);
            }
            if($billing_company_fca_number != $data->billing_company_fca_number){
                $message = " Advisor billing company fca number updated";
                $msg = implode(' ', array($name, $message));
                $this->saveActivity($request, $msg);
            }
         }
    }

    /**
     * Edit advisor Info
     */
    public function edit(Request $request){
        $advisor = $this->getModel()->withTrashed()->find($request->id);
        $first_name = $advisor->first_name;
        $last_name = $advisor->last_name;
        $name = $first_name .' '. $last_name;

        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.create',
            "title"             => "Edit Advisor",
            "form_url"          => route('advisor.create'),
            "reasons"           => PrimaryReason::where('publication_status', true)->orderBy("position", "ASC")->get(),
            "subscribe_reasons" => SubscribePrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
            "advisor_types"     => AdvisorType::where("publication_status", true)->orderBy("name", "ASC")->get(),
            "subscription_plans"=> SubscriptionPlan::where("office_manager", false)->get(),
            "professions"       => Profession::where("publication_status", true)->orderBy("name", "ASC")->get(),
            "service_offers"    => ServiceOffer::where("publication_status", true)->orderBy("position", "ASC")->get(),
            "fund_sizes"        => FundSize::where("publication_status", true)->orderBy("min_fund", "ASC")->get(),
            "data"              => $advisor,
            "edit"              => true,
        ];

        // $message = "Advisor Edit Page Open";
        // $msg = implode(' ', array($name, $message));
        // $this->saveActivity($request, $msg);

        //$this->saveActivity($request, "Advisor Edit Page Open", $advisor);
        return view('backEnd.advisor.create', $params);


    }

    /**
     * Show Import Page
     */
    public function showImport(Request $request){
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.import',
            "title"             => "Import Advisor",
            "form_url"          => route('advisor.import'),
        ];
        return view('backEnd.advisor.import', $params);
    }

    /**
     * Import File
     */
    public function import(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                "file"  => ["required", "file"]
            ]);
            if($validator->fails()){
                return back()->with("error", $this->getValidationError($validator));
            }
            Excel::import(new AdvisorListImport(), $request->file);
            return back()->with("success", "Import Successfully.");
        }catch(Exception $e){
            return back()->with("error", $this->getError($e));
        }
    }

    /**
     * Subscribe
     */
    public function subscribe(Request $request){
        try{
            $advisor = $this->getModel()->find($request->id);
            $office_manager_id = $advisor->office_manager_id;

            $advisor->subscribe = $request->subscribe;
            $advisor->save();
            if($request->subscribe){
                event(new Subscribe($advisor));
            }
            //$this->saveActivity($request, "Advisor subscribed status changed", $advisor);
            //$this->success('Advisor subscribed status changed successfully');
            if(!empty($office_manager_id)){

                $this->saveActivity($request, "Office Manager subscribed status changed", $advisor);
                $this->success('Office Manager subscribed status changed successfully');
            }
            else{
                $this->saveActivity($request, "Advisor subscribed status changed", $advisor);
                $this->success('Advisor subscribed status changed successfully');
            }
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected advisor As Archive
     */
    public function archive(Request $request){
        try{

            $data = $this->getModel()->withTrashed()->find($request->id);
            $name=$data->first_name.' '.$data->last_name;
            $data->delete();
            $this->success('Successfully archived');
            $this->saveActivity($request, $name. " Archived", $data);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected advisor As Active from Archive
     */
    public function restore(Request $request){
        try{

            $data = $this->getModel()->withTrashed()->find($request->id);
            $name = $data->first_name .' '. $data->last_name;
            $data->restore();
            $this->success(' Advisor restored successfully');
            $this->saveActivity($request, "Advisor ".$name. " Restore ", $data);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Permanent Delete of an  advisor
     */
    public function delete(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $name = $data->first_name .' '. $data->last_name;
            AdvisorBillingInfo::where('advisor_id', $data->id)->delete();
            Testimonial::where('advisor_id', $data->id)->forceDelete();
            AdvisorQuestion::where('advisor_id', $data->id)->forceDelete();
            AdvisorCompliance::where('advisor_id', $data->id)->delete();
            Interview::where('advisor_id', $data->id)->delete();

            $this->saveActivity($request, " Advisor ".$name. " permanently deleted", $data);
            $data->forceDelete();
            $this->success(' Advisor deleted successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive  Advisor List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable($request, 'archive');
        }
        $params = [
            'nav'               => 'advisor' ,
            'subNav'            => 'advisor.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => ' Advisor Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.advisor.table', $params);
    }

    /**
     * Send Verification Email
     */
    public function sendVerificationEmail(Request $request){
        try{
            $advisor = $this->getModel()->withTrashed()->find($request->id);
            $advisor->sendEmailVerificationNotification();
            $this->success("Verification email has sent successfully");
            $this->saveActivity($request, "Sent Email Verification Link", $advisor);
            $this->button = true;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make Email Verify
     */
    public function emailVerify(Request $request){
        try{
            $advisor = $this->getModel()->withTrashed()->find($request->id);
            $advisor->email_verified_at = Carbon::now();
            $advisor->save();
            $this->success("Email verified successfully");
            $this->saveActivity($request, "Make Email as Verified", $advisor);
            $this->button = true;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Change Password Page
     */
    public function changePasswordPage(Request $request){
        $advisor = User::find($request->id);

        $params = [
            'title' => "Change Password",
            "form_url" => route('advisor.change_password', ['id' => $request->id]),
            'data'  => $advisor,
        ];
        return view('backEnd.advisor.change-password', $params );
    }

    /**
     * Password Changed
     */
    public function changePassword(Request $request){
        $validate = Validator::make($request->all(),[
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
        if($validate->fails()){
            $this->message = $this->getValidationError($validate);
            return $this->output();
        }
        $advisor = User::find($request->id);
        $advisor->password = bcrypt($request->password);
        $advisor->save();
        $this->saveActivity($request, "Advisor Password Change", $advisor);
        $this->success("Password has been changed successfully");
        return $this->output();
    }

    /**
     * Assign Advisor under Office Manager Page Showw
     */
    public function assignOfficeManagerPage(Request $request){
        $advisor = User::find($request->id);
        $office_managers = User::whereHas("subscription_plan", function($qry){
            $qry->where("office_manager", true);
        })->where("office_manager_id", null)->get();

        $params = [
            'title'                 => "Assign Advisor Under Office Manager",
            "form_url"              => route('advisor.assign_office_manager', [$request->id]),
            "office_manager_list"   => $office_managers,
            'data'                  => $advisor,
        ];
        return view('backEnd.advisor.assign-advisor-under-office-manager', $params );
    }

    /**
     * Assign Advisor under Office Manager
     */
    public function assignOfficeManager(Request $request){
        $office_manager = User::find($request->office_manager_id);
        $max_advisor_allow = $office_manager->subscription_plan->max_advisor ?? 0;
        $current_advisor_profile = count($office_manager->advisor_profiles());
        if($max_advisor_allow <= $current_advisor_profile ){
            $this->message = "Your advisor add limit over. Your plan allow max ".$max_advisor_allow . ' advisor';
            return $this->output();
        }

        $advisor = User::find($request->id);
        $advisor->office_manager_id = $request->office_manager_id;
        $advisor->save();
        $this->saveActivity($request, "Assign Under Office Manager", $advisor);
        $this->success("Successfully assigned to office manager");
        return $this->output();
    }

    /**
     * Unsigned Office Manager
     */
    public function unAssignOfficeManager(Request $request){
        $advisor = User::find($request->id);
        $advisor->office_manager_id = null;
        $advisor->save();
        $this->saveActivity($request, "Unsigned From Office Manager", $advisor);
        $this->success("Successfully assigned from office manager");
        return $this->output();
    }


    /**
     * Get advisor DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($request, $type = 'list', $missing_info = false){
        $subscribe = true;
        if( isset($request->subscribe) ){
            $subscribe = $request->subscribe;
        }
        if( $type == "list" ){
            $data = $this->getModel();
        }else{
            $data = $this->getModel()->onlyTrashed();
        }

        // Type Filter
        if( $type == "list" ){
            if( isset($request->type) && $request->type == "filter"){
                $data = $data->where('advisors.created_at', 'like', $request->type_value.'%');
            }
            if( isset($request->type) && $request->type == "plan"){
                $data = $data->whereHas('subscription_plan', function($qry) use($request){
                    $qry->where('name', $request->type_value);
                });
            }
            if( !$request->type && !$missing_info){
                $data = $data->where('subscribe', $subscribe);
            }

           
            if( $missing_info ){
                $data = $data->where(function($qry){                   
                    $qry->where("town", "tbc")->orWhere("country", "tbc")->orwhere("address_line_one", "tbc")
                    ->orWhereHas("billing_info", function($qry){
                        $qry->where("billing_address_line_one", "tbc")->orWhere("billing_town", "tbc")->orWhere("billing_country", "tbc");
                    });
                });
            }
        }

        $data = $data->leftjoin('primary_reasons', 'primary_reasons.id', '=','advisors.primary_region_id')
            ->where(function($qry){
                $qry->whereHas("subscription_plan", function($qry){
                    $qry->where("office_manager", false);
                })->orWhere("office_manager_id", "!=", null);
            })
            ->select('advisors.*', 'primary_reasons.name as primary_reason')
            ->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();

        $system = System::first();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('subscription', function($row){ return $row->subscription_plan->name ?? "N/A"; })
            /*->addColumn('name', function($row){ return ($row->first_name ?? "" . ' '. $row->last_name ?? ""); })*/
            ->addColumn('advisor', function($row){ return ($row->first_name. ' '.$row->last_name ); })
            ->addColumn('subscribe_primaty_reason', function($row){ return substr($row->subscribe_primary_reason(), 0, 60); })
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('area_covered', function($row){
                if( !empty($row->location_postcode_id) && is_array($row->location_postcode_id)){
                    return substr($row->postcodesCovered(), 0, "70").'....';
                }
                return  "N/A";
            })
            ->addColumn('subscribe_area_covered', function($row){
                if( !empty($row->subscribe_location_postcode_id) && is_array($row->subscribe_location_postcode_id)){
                    return wordwrap($row->postcodesCovered(null, true),60,"<br>\n");
                }
                return  "N/A";
            })
            ->addColumn('action', function($row) use($type, $subscribe){
                $li = "";
                if($type == 'list'){
                    $li = '<a href="'.route('advisor.view',['id' => $row->id]).'" class="btn btn-sm btn-primary" title="Advisor Profile" target="_blank"> <span class="fa fa-user fa-lg"></span> Advisor Admin</a> ';
                    $li .= '<a href="'.route('advisor.view-postcode',['id' => $row->id]).'" class="btn btn-sm btn-info ajax-click-page" title="Advisor Postcode"> <span class="fa fa-eye fa-lg"></span> View Postcode</a> ';
                }
                if(AccessController::checkAccess("advisor_update")){
                    $li .= '<a href="'.route('advisor.edit',['id' => $row->id]).'" class="btn btn-sm btn-warning" title="Edit" > <span class="fa fa-edit fa-lg"></span> Edit</a> ';
                    $li .= '<a href="'.route('advisor.change_password',['id' => $row->id]).'" class="btn btn-sm btn-dark ajax-click-page" title="Edit" > <span class="fa fa-edit fa-lg"></span>Change Password</a> ';
                    if(isset($row->officeManager)){
                        $li .= '<a href="'.route('advisor.unassign_office_manager',['id' => $row->id]).'" class="btn btn-sm btn-danger ajax-click" title="Assign Under a Office Manager" > <i class="fa fa-clipboard-check"></i>Unassign Office Manager</a> ';
                    }else{
                        $li .= '<a href="'.route('advisor.assign_office_manager',['id' => $row->id]).'" class="btn btn-sm btn-primary ajax-click-page" title="Assign Under a Office Manager" > <i class="fa fa-clipboard-check"></i>Assign Office Manager</a> ';
                    }
                }
                if(empty($row->email_verified_at)){
                    $li .= '<a href="'.route('advisor.make_email_verify',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-success" title="Make Email Verify" > <i class="far fa-check-square fa-lg"></i> Manually Verify</a> ';
                    $li .= '<a href="'.route('advisor.send_email_verification',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-warning" title="Send Verification Email" > <span class="far fa-envelope fa-lg"></span> Send verification email </a> ';
                }
                $li .= '<a href="'.route('advisor.view_march_rating',['id' => $row->id]).'" class="btn btn-sm btn-warning" title="View Match Rating" target="_blank"> <span class="fa fa-eye fa-lg"></span> Match Rating</a> ';
                if($type == 'list'){
                    if(AccessController::checkAccess("advisor_delete")){
                        $li .= '<a href="'.route('advisor.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash fa-lg" title="Delete" ></span> Delete</a> ';
                    }
                }else{
                    if(AccessController::checkAccess("advisor_restore")){
                        $li .= '<a href="'.route('advisor.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo fa-lg"></i> Restore</a> ';
                    }
                    if(AccessController::checkAccess("advisor_delete")){
                        $li .= '<a href="'.route('advisor.delete',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash fa-lg" title="Delete" ></span> Permanent Delete</a> ';
                    }
                }
                return $li;
            })
            ->editColumn('subscribe', function($row)use($subscribe){
                if( !$subscribe ){
                    return '<a href="'.route('advisor.subscribe',[$row->id, 1]).'" class="ajax-click btn btn-sm btn-warning" title="Unsubscribed" >Unsubscribed</a> ';
                }else{
                    return '<a href="'.route('advisor.subscribe',[$row->id, 0]).'" class="ajax-click btn btn-sm btn-success" title="Subscribed" >Subscribed</a> ';
                }
            })
            ->addcolumn('profession', function($row){ return $row->profession->name ?? ""; })
            ->addcolumn('profile_name', function($row){ return $row->firm_details->profile_name; })
            ->editColumn('status', function($row){ return $this->getStatus($row->status); })
            ->addcolumn('live', function($row){ return $row->is_live == 1 ? '<input type="checkbox" checked>' : '<input type="checkbox">'; })
            ->addColumn("email_verify", function($row){ return !empty($row->email_verified_at) ? $this->getStatus('verified') : $this->getStatus('not_verified') ; })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status', 'email_verify', 'area_covered', "subscribe_area_covered",'subscribe', 'status','live'])
            ->make(true);
    }

    /**
     * Advisor Dashboard
     * First Login into Authentication guard
     * Then Redirect Advisor Panel
     */
    public function dashboard(Request $request){
        $advisor = User::withTrashed()->find($request->id);
        $office_manager = $advisor->subscription_plan->office_manager ?? false;
        if($office_manager){
            Auth::guard("office_manager")->login($advisor);
        }
        Auth::guard("web")->login($advisor);
        return redirect()->route('advisor.dashboard');
    }

    /**
     * View PostCodes
     */
    public function viewPostcodes(Request $request){
        $params = [
            "advisor"           => User::find($request->id),
        ];
        return view('backEnd.advisor.view-post-code', $params);
    }

    /**
     * View Or Show Advisor Match Rating
     */
    public function viewMatchRating(Request $request){
        $advisor = User::withTrashed()->find($request->id);
        Auth::guard("web")->login($advisor);
        return redirect()->route('advisor.match_rating');
    }

    /******************************************************************************
     * Advisor Billing Section
     */

     /**
     * Get Table Column List
     */
    private function getBillingColumns(){
        return ['#','billing_id', "advisor", 'contact_name', 'company_name', "company_number",'post_code','address','plan','terms_and_condition_agree_date', 'action'];

    }

    /**
     * Get DataTable Column List
     */
    private function getBillingDataTableColumns(){
        return ['index', 'billing_id', "advisor", 'contact_name', 'billing_company_name', "billing_company_fca_number",'post_code', 'address','subscription','terms_and_condition_agree_date','action'];
    }

    /**
     * Advisor Billing List
     */
    public function advisorBillingList(Request $request){
        if( $request->ajax() ){
            return $this->getBillingDataTable();
        }

        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.billing_list',
            'tableColumns'      => $this->getBillingColumns(),
            'dataTableColumns'  => $this->getBillingDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'All Advisor Billings',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * View Billing Details
     */
    public function advisorBillingView(Request $request){
        $params = [
            "data"      => AdvisorBillingInfo::find($request->id)
        ];
        //$this->saveActivity($request, "View Advisor Billing Info");
        return view('backEnd.advisor.view-billing', $params)->render();
    }

    /**
     * Edit Billing Info
     */
    public function advisorBillingEdit(Request $request){
        $params = [
            "title"     => "Update Advisor Billng Information",
            "form_url"  => route('advisor.billing_edit',[$request->id]),
            "data"      => AdvisorBillingInfo::find($request->id),
        ];
        //$this->saveActivity($request, "Edit Advisor Billing Info");
        return view('backEnd.advisor.edit-billing', $params);
    }

    /**
     * Save Updated Billing Info
     */
    public function advisorBillingSave(Request $request){
        try{
            $data_arr = $request->except(['_token', 'id']);
            AdvisorBillingInfo::where('id', $request->id)->update($data_arr);
            $this->success('Billing information saved successfully');
            $this->saveActivity($request, $request->contact_name." advisor billing updated ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Billing DataTable
     */
    protected function getBillingDataTable(){
        $advisors = User::where(function($qry){
            $qry->whereHas("subscription_plan", function($qry){
                $qry->where("office_manager", false);
            })->orWhere("office_manager_id", "!=", null);
        })->orderBy('id', 'DESC')->get();

        return DataTables::of($advisors)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('advisor', function($row){
                return (($row->first_name ?? 'N/A'). ' ' .($row->last_name ?? null));
            })
            ->addColumn('post_code', function($row){ return $row->billing_info->billing_post_code ?? "N/A"; })
            ->addColumn('billing_id', function($row){ return $row->billing_info->id ?? "N/A"; })
            ->addColumn("contact_name", function($row){ return $row->billing_info->contact_name ?? "N/A"; })
            ->addColumn("billing_company_name", function($row){ return $row->billing_info->billing_company_name ?? "N/A"; })
            ->addColumn("billing_company_fca_number", function($row){ return $row->billing_info->billing_company_fca_number ?? "N/A"; })

            ->addColumn('address', function($row){ return ($row->billing_info->billing_address_line_one ?? ""). ' ' . ($row->billing_info->billing_address_line_two ?? ""); })
            ->addColumn('subscription', function($row){
                return  $row->subscription_plan->name ?? "N/A";
             })
            ->addColumn('action', function($row){
                if( isset($row->billing_info->id) ){
                    $li = '<a href="'.route('advisor.billing_view',[$row->billing_info->id]).'" class="btn btn-sm btn-primary ajax-click-page" title="Advisor Profile" target="_blank"> <span class="fa fa-eye fa-lg"></span> </a> ';
                    $li .= '<a href="'.route('advisor.billing_edit',[$row->billing_info->id]).'" class="btn btn-sm btn-info ajax-click-page" title="Edit" > <span class="fa fa-edit fa-lg"></span> </a> ';
                    return $li;
                }
            })
        ->make(true);
    }

    /*************************************************************************************************
     * Promotional Advisor List
     */
    /**
     * Advisor Billing List
     */
    public function advisorPromotionalList(Request $request){
        if( $request->ajax() ){
            return $this->getPromotionalDataTable();
        }
        //$this->saveActivity($request, "View Advisor Promotional List");
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.promotional_list',
            'tableColumns'      => $this->getPromotionalColumns(),
            'dataTableColumns'  => $this->getPromotionalTableColumns(),
            'create'            => AccessController::checkAccess(['promotional_create']) ? route('advisor.promotional_create') : false,
            'pageTitle'         => 'All Promotional Advisor List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create Promotional List
     */
    public function advisorPromotionalCreate(Request $request){
        $promotional_advisors_arr = PromotionalAdvisor::select('advisor_id')->get()->toArray();
        //$this->saveActivity($request, "Advisor promotional list add page open");
        $params = [
            "title"     => "Add Promotional Advisor",
            "form_url"  => route('advisor.promotional_create'),
            "advisors"  => User::whereNotIn('id', $promotional_advisors_arr)->orderBy('id', 'asc')->get(),
        ];
        return view('backEnd.advisor.promotional', $params);
    }

    /**
     * Edit Promotional List
     */
    public function advisorPromotionalEdit(Request $request){
        $promotional_advisors_arr = PromotionalAdvisor::where('advisor_id', $request->id)->select('advisor_id')->get()->toArray();
        $params = [
            "title"     => "Edit Promotional Advisor",
            "form_url"  => route('advisor.promotional_create'),
            "advisors"  => User::whereNotIn('id', $promotional_advisors_arr)->orderBy('id', 'asc')->get(),
            "data"      => PromotionalAdvisor::where('id', $request->id)->first(),
        ];
        //$this->saveActivity($request, "Advisor promotional list Edit page open");
        return view('backEnd.advisor.promotional', $params);
    }
    
    
     /**
     * Save Promotional List
     */
    public function advisorPromotionalStore(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'advisor_id'    => ['required', 'numeric', 'min:1'],
                'position'      => ['required', 'numeric', 'min:1'],
                'publication_status' => ['required', 'boolean', 'min:1'],
            ]);           

            if($validator->fails()){
                $this->message = $this->getValidationError($validator);
                return $this->output();
            }

            $advisor = User::withTrashed()->find($request->advisor_id);
            $advisor = ($advisor->first_name ?? ""). ' ' . ($advisor->last_name ?? "");
            $data_arr = $request->except(['_token', 'id']);

            if($request->id == 0){
                PromotionalAdvisor::insert($data_arr);
                $this->saveActivity($request, "Add ". $advisor ." Advisor into promotional list");
            }else{
                $this->saveActivity($request, "Update ". $advisor ." Advisor into promotional list");
                PromotionalAdvisor::where('id', $request->id)->update($data_arr);
            }
            $this->success('Promotional advisor information saved successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }
    
    
    

    /**
     * Delete / Remove Advisor from Promotional Advisor List
     */
    public function advisorPromotionalDelete(Request $request){
        try{
            PromotionalAdvisor::where('id', $request->id)->delete();
            $this->saveActivity($request, "Delete Advisor from promotional list");
            $this->success('Promotional advisor information deleted successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Get Table Column List
     */
    private function getPromotionalColumns(){
        return ['#', "advisor", 'position', 'publication_status', 'action'];

    }

    /**
     * Get DataTable Column List
     */
    private function getPromotionalTableColumns(){
        return ['index', "advisor", 'position', 'publication_status', 'action'];
    }

    /**
     * Promotional Advisor List Datatable
     */
    protected function getPromotionalDataTable(){
        $datas = PromotionalAdvisor::orderBy('position', 'ASC')->get();
        return DataTables::of($datas)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('advisor', function($row){ return (($row->advisor->first_name ?? "N/A") . ' ' . ($row->advisor->last_name ?? "")); })
            ->editColumn('publication_status', function($row){ return $this->getStatus($row->publication_status); })
            ->addColumn('action', function($row){
                $li = '<a href="'.route('advisor.promotional_edit',[$row->id]).'" class="btn btn-sm btn-info ajax-click-page" title="Edit" > <span class="fa fa-edit fa-lg"></span> </a> ';
                $li .= '<a href="'.route('advisor.promotional_delete',[$row->id]).'" class="btn btn-sm btn-danger ajax-click" title="Delete" > <span class="fa fa-trash fa-lg"></span> </a> ';
                return $li;
            })
        ->rawColumns(['publication_status', 'action'])->make(true);
    }

}
