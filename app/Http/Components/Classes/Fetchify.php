<?php

namespace App\Http\Components\Classes;

use Illuminate\Support\Facades\Http;

class Fetchify{

    protected $key;
    protected $email_validate_url = "https://api.craftyclicks.co.uk/email/1.0/validate";
    protected $phone_validate_url = "https://api.craftyclicks.co.uk/phone/1.0/validate";
    protected $postcode_validate_url = "https://pcls1.craftyclicks.co.uk/json/rapidaddress";
    protected $status = false;
    protected $message = "Invalid";
    protected $api_response;

    /**
     * Class Instance Constructor
     */
    function __construct()
    {
        $this->key = env("FETCHIFY_API_KEY", "08285-80501-27044-06d46");
    }

    /**
     * API Response
     * @return Array
     */
    protected function output($status = null, $message = null, $data = null){
        $this->status = $status ?? $this->status;
        $this->message = $message ?? $this->message;
        $this->api_response = $data ?? $this->api_response;
        return [
            'status'    => $this->status,
            "message"   => $this->message,
            "api_response"=>  $this->api_response,
        ];
    }

    /**
     * Validate Email
     */
    public function isValidEmail($email){
        $params = [
            "key"   => $this->key,
            "email" => $email,
        ];
        $response = Http::post($this->email_validate_url, $params)->object();
        $this->status = $response->result ?? false;
        $this->message = $this->status ? "The Email Address is Valid" : "The Email Address is not Valid";
        $this->api_response = $response;
        return $this->output();
    }

    /**
     * Validate Phone
     */
    public function isValidPhone($phone_no, $country = "GB"){
        $params = [
            "key"           => $this->key,
            "phone_number"  => $phone_no,
            "country"       => $country,
        ];
        $response = Http::post($this->phone_validate_url, $params)->object();
        $this->status = $response->result ?? "false";
        $this->message = $this->status ? "The Phone number is Valid" : "The Phone Number is Not Valid";
        $this->api_response = $response;
        return $this->output();
    }

    /**
     * Validate Phone
     */
    public function isValidPostCode($post_code){
        $params = [
            "key"       => $this->key,
            "postcode"  => $post_code,
            "response"  => "data_formatted",
        ];
        $response = Http::post($this->postcode_validate_url, $params)->object();
        if( isset($response->error_code) ){
            return $this->output(false, "Postcode is not valid", $response);
        }
        return $this->output(true, "Postcode is valid", $response);
    }
}