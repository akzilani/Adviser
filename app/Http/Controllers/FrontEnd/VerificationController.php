<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Components\Classes\Fetchify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * verification
     */
    public function verify(Request $request){
        if( !$this->isfetchFyEnable($request->page) ){
            $this->status = true;
            $this->message = "Fetchfy Disabled";
            return $this->apiOutput();
        }

        if( empty($request->field) ){
            return $this->emptyResponse();
        }
        if( $request->field == "phone" ){
            $response = (new Fetchify())->isValidPhone($request->field_value, "GB");
            return $this->responseOutput($response);
        }
        elseif( $request->field == "email" ){
            $response = (new Fetchify())->isValidEmail($request->field_value);
            return $this->responseOutput($response);
        }
        elseif( $request->field == "postcode" ){
            $response = (new Fetchify())->isValidPostCode($request->field_value);
            return $this->responseOutput($response);
        }else{
            return $this->emptyResponse();
        }
        
    }

    /**
     * Verification Output
     */
    protected function responseOutput($response){
        $this->status = $response["status"];
        $this->message = $response["message"];
        $this->data = $response["api_response"];
        return $this->apiOutput();
    }


    /**
     * Empty Response From APi
     */
    protected function emptyResponse(){
        $this->message = "Phone Number is Required";
        return $this->apiOutput();
    }
}
