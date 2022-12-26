<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\System;
use Exception;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    /**
     * Create Website Settings
     */
    public function create(Request $request){
        $params = ['nav' => 'website.settings'];
        //$this->saveActivity($request, "Website Settings Create Page Open"); 
        return view('backEnd.admin.settings', $params);
    }

    /**
     * Save website Settings Information
     */
    public function store(Request $request){
        try{
            // $this->addMonitoring('Website Settings','Update');
            $system = System::first();
            if( empty($system) ){
                $system = new System();
            }
            $system->application_name = $request->application_name;
            $system->title_name = $request->title_name;
            $system->phone = $request->phone;
            $system->email = $request->email;
            $system->city = $request->city;
            $system->postal_code = $request->postal_code;
            $system->address = $request->address;
            $system->state = $request->state;
            $system->country = $request->country;
            $system->currency = $request->currency;
            $system->currency_symbol = $this->getCurrencySymbol($request->currency);
            $system->time_zone = $request->time_zone;
            $system->date_format = $request->date_format;
            $system->logo = $this->uploadImage($request, 'logo', $this->logo_dir, null, 100, $system->logo);
            $system->favicon = $this->uploadImage($request, 'favicon', $this->logo_dir, 35, 35, $system->favicon);
            $system->save();
            $this->success('Website settings updated successfully', false, false, false, true);
            $this->saveActivity($request, "Website settings updated", $system); 
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }
}
