<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class IncompleteProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try{
            $auth_user = $request->user();
            if(
                isset($auth_user->billing_info->billing_town) && (
                strtolower($auth_user->billing_info->billing_town) == "tbc" || 
                strtolower($auth_user->billing_info->billing_country) == "tbc" ||
                strtolower($auth_user->billing_info->billing_company_fca_number) == "tbc" ||
                strtolower($auth_user->billing_info->billing_company_name) == "tbc" ||
                strtolower($auth_user->billing_info->billing_address_line_one) == "tbc")
            ){
                return redirect()->route('advisor.billing_info')->with("error", "Please update your billng information");
            }
            elseif( 
                strtolower($auth_user->town) == "tbc" || 
                strtolower($auth_user->country) == "tbc" ||
                strtolower($auth_user->address_line_one) == "tbc" ||
                strtolower($auth_user->address_line_two) == "tbc"
            )
            {
                return redirect()->route('advisor.profile_update')->with("error", "Your profile is incomplete. Please complete your profile");
            }
            elseif( 
                strtolower($auth_user->firm_details->profile_name) == "tbc" || 
                strtolower($auth_user->firm_details->profile_details) == "tbc" ||
                strtolower($auth_user->firm_details->firm_fca_number) == "tbc" ||
                strtolower($auth_user->firm_details->firm_town) == "tbc" ||
                strtolower($auth_user->firm_details->firm_post_code) == "tbc" ||
                strtolower($auth_user->firm_details->firm_country) == "tbc" ||
                strtolower($auth_user->firm_details->firm_address_line_one) == "tbc" ||
                strtolower($auth_user->firm_details->firm_address_line_two) == "tbc" ||
                strtolower($auth_user->firm_details->linkedin_id) == "tbc"
            )
            {
                return redirect()->route('advisor.firm')->with("error", "Please update your firm details");
            }
            
        }catch(Exception $e){
            
        }
        return $next($request);
    }
}
