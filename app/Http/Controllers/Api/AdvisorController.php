<?php

namespace App\Http\Controllers\Api;

use App\AdvisorBillingInfo;
use App\AdvisorType;
use App\FirmDetails;
use App\FundSize;
use App\Http\Controllers\Controller;
use App\PrimaryReason;
use App\Profession;
use App\ServiceOffer;
use App\SubscriptionPlan;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdvisorController extends Controller
{
    /**
     * Advisor Create 
     * Required Data Provide
     */
    public function create(Request $request){
        try{
            $data = [
                "reasons"           => PrimaryReason::where('publication_status', true)->orderBy('position', 'ASC')->get(),
                "advisor_types"     => AdvisorType::where("publication_status", true)->orderBy("name", "ASC")->get(),
                "subscription_plans"=> SubscriptionPlan::get(),
                "professions"       => Profession::where("publication_status", true)->orderBy("name", "ASC")->get(),
                "service_offers"    => ServiceOffer::where("publication_status", true)->orderBy("id", "ASC")->get(),
                "fund_sizes"        => FundSize::where("publication_status", true)->orderBy("name", "ASC")->get(),
            ];
            $this->data = $data;
            $this->apiSuccess("Advisor Creation Data load Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            $this->message = $this->getError($e);
            return $this->apiOutput(500);
        }
    }

    /**
     * Save Advisor Information
     */
    /**
     * Store advisor Information
     */
    public function store(Request $request){
        try{
            $validator_data = [
                'profession_id'     => ['required','numeric','min:1'],
                "first_name"        => ['required','string','min:2', 'max:100'],
                "last_name"         => ['nullable','string','min:2', 'max:100'],
                "email"             => ['required','email', $request->id == 0 ? 'unique:advisors' : null],
                "password"          => [ $request->id == 0 ? 'required' : 'nullable','string','min:4', 'max:100'],
                "phone"             => ['required','string','min:9', 'max:15'],
                "telephone"         => ['nullable','string','min:9', 'max:15'],
                "personal_fca_number"=>['nullable','string','min:2', 'max:100'],
                "address_line_one"  => ['required','string','min:2', 'max:191'],
                "address_line_two"  => ['nullable','string','min:1', 'max:191'],
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
            $validator = Validator::make($request->all(), $validator_data);
            
            DB::beginTransaction();
            if( $request->id == 0 ){
                if( $validator->fails() ){
                    return back()->with("error", $this->getValidationError($validator))->withInput();
                }
                $data = $this->getModel();
            }else{
                $data = $this->getModel()->withTrashed()->find($request->id);
            }

            $data->profession_id = $request->profession_id;            
            $data->first_name = $request->first_name;            
            $data->last_name = $request->last_name;            
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->telephone = $request->telephone;
            $data->personal_fca_number = $request->personal_fca_number;
            $data->password = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->address_line_one = $request->address_line_one;
            $data->address_line_two = $request->address_line_two;
            $data->post_code = $request->post_code;
            $data->town = $request->town;
            $data->country = $request->country;
            $data->subscription_plan_id = $request->subscription_plan_id;
            $data->fund_size_id = $request->fund_size_id;
            $data->primary_region_id = $request->primary_region_id;
            $data->status = $request->status;
            $data->advisor_type_id = $request->advisor_type_id;
            $data->service_offered_id = $request->service_offered_id;
            $data->location_postcode_id = $request->location_postcode_id;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->image = $this->uploadImage($request, 'image', $this->advisor_image, null, null, $data->image);
            $data->save();
            $this->saveFirmInfo($request, $data);
            $this->saveBillingInfo($request, $data);
            $this->success('Advisor Information Add Successfully');
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($this->getError($e));
            return back()->with("error", $this->getError($e))->withInput();
        }

        return back()->with("success", $request->id == 0 ? "Advisor Create Successfully" : "Advisor updated successfully");
    }

    /**
     * Save Firm Info
     */
    public function saveFirmInfo($request, $advisor){
        $data = $advisor->firm_details;
        if(empty($data)){
            $data = new FirmDetails();            
        }
        $data->advisor_id = $advisor->id;
        $data->profile_name = $request->profile_name;
        $data->profile_details = $request->profile_details;
        $data->firm_fca_number = $request->firm_fca_number;
        $data->firm_website_address = $request->firm_website_address;
        $data->linkedin_id = $request->linkedin_id;
        $data->save();
    }

    /**
     * Billing Info
     */
    public function saveBillingInfo($request, $advisor){
        $data = $advisor->billing_info;
        if(empty($data)){
            $data = new AdvisorBillingInfo();
        }
        $data->advisor_id = $advisor->id;
        $data->billing_address_line_one = $request->billing_address_line_one;
        $data->billing_address_line_two = $request->billing_address_line_two;
        $data->billing_town = $request->billing_town;
        $data->billing_post_code = $request->billing_post_code;
        $data->billing_country = $request->billing_country;
        $data->billing_company_name = $request->billing_company_name;
        $data->billing_company_fca_number = $request->billing_company_fca_number;
        $data->save();
    }

    /**
     * Advisor Login 
     */
    public function login(Request $request){
        try{
            $advisor = User::where('email', $request->email)->first();
            if( !empty($advisor) ){
                if( Hash::check($request->password, $advisor->password) ){
                    $this->message = "Congratulation! Login Successfully.";
                    return $this->apiOutput();
                }else{
                    $this->message = "Sorry! Credential is not match.";
                    return $this->apiOutput(401);
                }
            }else{
                $this->message = "No Account Found";
                return $this->apiOutput(401);
            }
        }catch(Exception $e){
            $this->message = $this->getError($e);
            return $this->apiOutput(500);
        }
        
    }
}
