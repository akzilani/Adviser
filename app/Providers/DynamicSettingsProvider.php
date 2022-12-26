<?php

namespace App\Providers;

use App\EmailConfiguration;
use App\System;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class DynamicSettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setTimeZone();
        $this->setEmailConfiguration();
    }

    /**
     * Set Custom TimeZone
     */
    protected function setTimeZone(){
        try{
            $settings = System::first();
            config(['app.timezone' => $settings->time_zone ?? "UTC"]);
        }catch(Exception $e){

        }
    }

    /**
     * Set Email Configuration
     */
    protected function setEmailConfiguration(){
        try{
            $email_config = EmailConfiguration::first();
            if( !empty($email_config) ){ 
                $config = [
                    'driver'     =>     $email_config->mail_mailer ?? 'sendmail',
                    'host'       =>     $email_config->mail_host,
                    'port'       =>     $email_config->mail_port ?? "587",
                    'username'   =>     $email_config->mail_username,
                    'password'   =>     $email_config->mail_password,
                    'encryption' =>     $email_config->mail_encryption ?? "tls",
                    "from"       => [
                        "name"   => $email_config->mail_from_name ?? "Regulated Advice",
                        "address"=> $email_config->mail_from_address ?? "support@regulatedadvice.co.uk",
                    ]
                ];
                Config::set('mail', $config);
            }

        }catch(Exception $e){

        }
    }
}
