<?php

namespace App\Http\Controllers\FrontEnd;

use App\FundSize;
use App\Http\Components\Classes\Fetchify;
use App\Http\Components\Traits\Communication;
use App\Http\Controllers\Controller;
use App\Leads;
use App\ServiceOffer;
use App\TremsAndCondition;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    use Communication;
    /**
     * Ask Question
     */
    public function askNow(Request $request){
        $this->validate($request, [
            "first_name"        => ['required', "string", "min:2", "max:100"],
            "last_name"         => ['nullable', "string", "min:2", "max:100"],
            "email"             => ['required', "email", "min:3", "max:100"],
            "phone"             => ["required", "string", "min:2", "max:15"],
            "post_code"         => ["required", "string", "min:4", "max:8"],
            "question"          => ["required", "string", "min:5", "max:191"],
            "service_offer_id"  => ["required", "numeric", "min:1"],
            "fund_size_id"      => ["required", "numeric", "min:1"],
        ],[
            'first_name.min'    => "First name must be at least 2 characters",
            'last_name.min'     => "Last name must be at least 2 characters",
            'phone.min'         => "Phone number must be at least 2 characters",
            'post_code.min'     => "Postcode must be at least 2 characters",
            "post_code.required"=> "Postcode is required",
            'question.min'      => "Question must be at least 2 characters",
        ]);
        
        $fetchify_validate = true;
        if($this->isfetchFyEnable()){
            $fetchify_validate_error_message = [];
            // Phone Validate
            $response =  (new Fetchify())->isValidPhone($request->phone);
            if( !$response["status"] ){
                $fetchify_validate = false;
                $fetchify_validate_error_message["phone"] = "Phone number is invalid";
            }
            // Email Validate
            $response =  (new Fetchify())->isValidEmail($request->email);
            if( !$response["status"] ){
                $fetchify_validate = false;
                $fetchify_validate_error_message["email"] = "Email address invalid ";
            }
            // Postcode Validate
            $response =  (new Fetchify())->isValidPostCode($request->post_code);
            if( !$response["status"] ){
                $fetchify_validate = false;
                $fetchify_validate_error_message["post_code"] = "Postcode is invalid";
            }
            if( !$fetchify_validate ){
                return back()->withInput()->withErrors($fetchify_validate_error_message);
            }
        }

        $lead = new Leads();
        $lead->name = $request->first_name;
        $lead->last_name = $request->last_name;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->post_code = $request->post_code;
        $lead->question = $request->question;
        $lead->type = "match me";
        $lead->date = date('Y-m-d');
        $lead->publication_status = true;
        $lead->service_offer_id = (array) $request->service_offer_id;
        $lead->fund_size_id = $request->fund_size_id;
        $lead->save();
        // Add Comunication Message
        $this->addCommunicationMessage($lead->toArray(), "Congratulations! You just received a new lead");
        Session::put("lead", $lead);
        Session::put("post_code", $request->post_code);
        if( $request->mortgage_only && $request->mortgage_only == 1){
            return redirect()->route('search_advisor', ['Mortgage-Advisor']);
        }
        return redirect()->route('search_advisor');
        
    }

    /**
     * Search Advisor
     */
    public function advisorList(Request $request){
        $lead       = Session::get("lead");
        $post_code  = Session::get("post_code");
        if($request->advisor_type && !empty($request->advisor_type) ){
            Session::put("filter", $request->advisor_type);
        }

        if( !$request->ajax() ){
            $dynamic_page = TremsAndCondition::where("type", "Advisor List Page Popup")->first();
            $dynamic_page_blue_box = TremsAndCondition::where("type", "Advisor List Page Blue Box Header")->first();
            $dynamic_page_blue_box_paragraph = TremsAndCondition::where("type", "Advisor List Page Blue Box Paragraph")->first();
            $params = [
                'post_code' => $post_code,
                "lead"      => $lead,
                "popup_content" => $dynamic_page->trems_and_condition ?? "",
                "blue_box_content_header" => $dynamic_page_blue_box->trems_and_condition ?? "",
                "blue_box_content_paragraph" => $dynamic_page_blue_box_paragraph->trems_and_condition ?? "",
                "fund_size" => FundSize::orderBy("min_fund", "ASC")->get(),
                "form_url"  => route("find_advisor"),
                "service_offers" => ServiceOffer::where("publication_status", true)	->orderBy('position', 'ASC')->get(),
            ];
            return view('frontEnd.search.advisor-list', $params);
        }

        $latitude = $longitude = 0;
        if($post_code){          
            $data =  $this->getPostalCodeData($post_code);
            if( !isset($data->result->latitude) ){
                return response()->json([
                    'page' => "",
                ], 200);
            }
            $latitude = $data->result->latitude;
            $longitude  = $data->result->longitude;
            
            // default distance
            $distance = "55.92";
        }
        $filter_profession = Session::has("filter") ? str_replace('-', ' ', Session::get("filter")) : Null;

        $advisor_list = User::where('advisors.status', 'active')->where("advisors.is_live", true)
        ->whereHas("subscription_plan", function($qry){
            $qry->where("office_manager", false);
        });

        if(!empty($filter_profession)){
            $advisor_list->whereHas('profession', function($qry) use($filter_profession){
                $qry->where('name', $filter_profession);
            });
        }
        if($post_code){
            $advisor_list->whereRaw(DB::raw( "(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  *
            cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians( latitude ) ) ) ) < $distance "))      
            ->orderBy(DB::raw('ABS(latitude - '.(float)$latitude.') + ABS(longitude - '.(float)$longitude.')'), 'ASC');
        }
        $advisor_list = $advisor_list->select('advisors.*', "advisors.non_specific_rating as rating")
            ->orderBy('rating','desc')
            ->groupBy('id')
            ->paginate(10);
            
        foreach($advisor_list as $advisor){
            $advisor->travel_time = $this->calculateTimeDifference($latitude, $longitude, $advisor->latitude, $advisor->longitude);
        }
        $prams = [
            'advisors' => $advisor_list,
            "show_match_rating" => isset($distance) && $distance == 10000 ? true : false,
        ];
        return response()->json([
            'page' => $this->advisorListRender($prams),
        ], 200);
    }

    /**
     * Find Advisor
     * Default Distance $distance = 55.92;
     * For March Rating $distance = 60
     */
    public function findAdvisor(Request $request){
        $distance = 55.92;
        $match_rating = false;
        $service_offer = "";
        Session::put("post_code", $request->post_code);

        if( !empty($request->distance) ){
            $distance = $request->distance;
        }
        $data = $this->getPostalCodeData($request->post_code);
        $latitude = $data->result->latitude;
        $longitude  = $data->result->longitude;
        
        $distance = $distance == 60 ? 10000 : $distance;

        $advisor_list = User::where('advisors.status', 'active')
        ->where("advisors.is_live", true)
        ->where(function($qry){
            $qry->whereHas("subscription_plan", function($qry){
                $qry->where("office_manager", false);
            })->orWhere("office_manager_id", "!=", null);
        });

        if(!empty($filter_profession)){
            $advisor_list->whereHas('profession', function($qry) use($filter_profession){
                $qry->where('name', $filter_profession);
            });
        }

        // Filter By  Area Of Advisor   
        if($distance == 10000){
            if( !empty($request->service_offer) ){
                $match_rating = true;
                $service_offer = ServiceOffer::where('id', $request->service_offer)->first();
                $advisor_list->whereHas('approve_advisor_questions', function ($query) use($request) {                            
                    $query->whereHas('service_offer', function($qry) use($request){
                        $qry->where('id', $request->service_offer);
                    });
                });
            }
        }            
        
        // Filter by fund Size
        if($request->fund_size != -1 || $request->fund_size > 0){
            $advisor_list->whereHas('fund_size', function($query) use($request){
                $query->where('min_fund', '>=', $request->fund_size);
            });
        }

        if(!empty($request->post_code)){
            $advisor_list->whereRaw(DB::raw( "(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  *
            cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians( latitude ) ) ) ) < $distance ")) ;
            // ->orderBy(DB::raw('ABS(latitude - '.(float)$latitude.') + ABS(longitude - '.(float)$longitude.')'), 'ASC');
        }
        
        if($match_rating){
            $advisor_list = $advisor_list->select('advisors.*', "advisors.specific_rating->".$service_offer->name." as rating",
            DB::raw( "(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  *
            cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians( latitude ) ) ) ) as distance "))
                ->groupBy('id');
        }else{
            $advisor_list = $advisor_list->select('advisors.*', "advisors.non_specific_rating as rating",
            DB::raw( "(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  *
            cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians( latitude ) ) ) ) as distance "))
                ->groupBy('id');
        }
        

        // For MatchRating $distance = 10000
        if($distance == 10000){
            $advisor_list = $advisor_list->orderBy('rating','desc')->orderBy('distance','asc');
        }else{
            $advisor_list = $advisor_list->orderBy('distance','asc')->orderBy('rating','desc');
        }  
        $advisor_list = $advisor_list->paginate(10);
        
        foreach($advisor_list as $advisor){
            $advisor->travel_time = $this->calculateTimeDifferenceFromDistance($advisor->distance);
            // $advisor->travel_time = $this->calculateTimeDifference($latitude, $longitude, $advisor->latitude, $advisor->longitude);
        }

        $prams = [
            "advisors" => $advisor_list,
            "show_match_rating" => isset($distance) && $distance == 10000 ? true : false,
        ];
        return response()->json([
            'page' => $this->advisorListRender($prams),
        ], 200);
            
    }

    /**
     * Load / Get Postal Code Data
     */
    public function getPostalCodeData($post_code){
        $url = "http://api.postcodes.io/postcodes/$post_code";           
        return $this->getResponse($url);
    }

    /**
     * Calculate Time Difference
     */
    public function calculateTimeDifference($lat1 = 0, $lon1 = 0, $lat2 = 0, $lon2 = 0){
        if(!$lat1 && !$lon1){
            return "";
        }
        
        $R = 6371; // km (change this constant to get miles)
        $delta_lat =  (Double)$lat2 - (Double)$lat1;
        $delta_lon = (Double)$lon2 - (Double)$lon1;
        $alpha    = $delta_lat/2;
        $beta     = $delta_lon/2;
          
        $a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
        $c        = asin(min(1, sqrt($a)));
        $distance = 2 * $R * $c;
        $distance = round($distance, 4);
        
        $time = $distance / 60;
        if( $time < 1 ){
            $t = round(60 * $time) . ' minutes';
        }else{
            $tim_exp = explode('.', $time);
            $hour = $tim_exp[0];
            $min = isset($tim_exp[1]) ? ($time - $tim_exp[0])  * 60 : 0;
            $t = $hour . ' hours ' . (int)$min . ' minute';
        }
        return $t;
    }

    /**
     * Calculate Time Difference
     */
    public function calculateTimeDifferenceFromDistance($distance){        
        $time = $distance / 60;
        if( $time < 1 ){
            $t = round(60 * $time) . ' minutes';
        }else{
            $tim_exp = explode('.', $time);
            $hour = $tim_exp[0];
            $min = isset($tim_exp[1]) ? ($time - $tim_exp[0])  * 60 : 0;
            $t = $hour . ' hours ' . (int)$min . ' minute';
        }
        return $t;
    }

    /**
     * Advisor List Render
     */
    protected function advisorListRender($params){        
        return view('frontEnd.search.advisor', $params)->render();
    }

    

}
