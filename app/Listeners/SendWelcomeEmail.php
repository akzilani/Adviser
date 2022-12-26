<?php

namespace App\Listeners;

use App\EmailTemplate;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail
{
    use Communication;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $advisor = User::find($event->user->id);
        $email_template = EmailTemplate::where('type', "welcome_email")->first();
        $subject = $email_template->subject ?? "Congratulations! You are now a Regulated advice advisor";
        $footer = $email_template->footer ?? "";
        $mail_message = $this->setDynamicValue($advisor, $email_template->body ?? "");
        
        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";

        // Save Communication Message
        //$this->addCommunicationMessage($mail_message, $subject, $advisor->id, true);
        
        $msg_params = [
            "mail_message" => $mail_message, 
            "mail_footer" => $footer
        ];
        //SendSingleMail::dispatch($advisor, $subject, $msg_params, "email.default")->delay(1);
        
        //new naimur
        if( isset($email_template->send_email) && $email_template->send_email==1){                
            // Save Communication Message
            $this->addCommunicationMessage($mail_message, $subject, $advisor->id, true);
            SendSingleMail::dispatch($advisor, $subject, $msg_params, "email.default", $email_template->send_to_cc)->delay(1);
        }

        if($third_party_email_send && !empty($third_party_email) ){
            SendThirdPartyMail::dispatch($third_party_email, $subject, $msg_params, "email.default")->delay(1); 
        }
    }

    /**
     * Set Dynamic Value into Email Template
     */
    protected function setDynamicValue($advisor, $mail_message){
        $system = System::first();
        $mail_message = str_replace("{PLATFORM_DATE}", Carbon::now()->format($system->date_format), $mail_message);

        $mail_message = str_replace("{ADVISOR_BILLING_ID}", $advisor->billing_info->id ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_SUBSCRIPTION_PLAN}", $advisor->subscription_plan->name ?? "", $mail_message);
        return $mail_message;
    }
    
}
