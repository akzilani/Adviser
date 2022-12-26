<?php

namespace App\Http\Components\Traits;

use App\Visitor;
use Jenssegers\Agent\Agent;
use Exception;
use Illuminate\Support\Facades\Session;

trait AdvisorProfileVisitor{

    use Helper;
    /**
     * Add / Store Visitor Information
     */
    protected function profileView($request, $advisor_id){
        $agent = new Agent();
        $data = new Visitor();
        $data->ip = $request->ip();        
        $data->browser = $agent->browser().$agent->version($agent->browser());
        $data->device =  $agent->isDesktop() == 1?'Desktop':$agent->device();
        $data->os = $agent->platform().'-'.$agent->version($agent->platform());
        $data->user_id = $advisor_id;
        try{
            $ip_details = $this->getDataFromIP($request->ip());
            $data->country_code = $ip_details->country;
            $data->city = $ip_details->city;
        }catch(Exception $e){
            $data->country_code = 'N/A';
            $data->city = "N/A";
        }  
        
        $data->visit_count = 1; 
        $data->date = date('Y-m-d');
        $data->save();
        return $data;
    }
}