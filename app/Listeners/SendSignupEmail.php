<?php

namespace App\Listeners;

use App\EmailTemplate;
use App\Events\Subscribe;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendSignupEmail
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

    public function handle(Subscribe $event)
    {
        if($event->send_signup_email){            
            $advisor = $event->user;
            $email_template = EmailTemplate::where('type', "signup_email")->first();

            $subject = $email_template->subject ?? "You are now subscribed";
            $footer = $email_template->footer ?? "";
            $mail_message = $this->setDynamicValue($advisor, $email_template->body ?? "");
            
            $third_party_email_send = $email_template->third_party_email_send ?? false;
            $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";

            // Save Communication Message
            $msg_params = [
                "advisor" => $advisor, 
                "mail_message" => $mail_message, 
                "mail_footer" => $footer
            ];
            
            if( isset($email_template->send_email) && $email_template->send_email){
                $this->addCommunicationMessage($mail_message, $subject, $advisor->id, true);
                SendSingleMail::dispatch($advisor, $subject, $msg_params, "email.default", $email_template->send_to_cc)->delay(1);            
            }

            if($third_party_email_send && !empty($third_party_email) ){
                SendThirdPartyMail::dispatch($third_party_email, $subject, $msg_params, "email.default_plain_body")->delay(1); 
            }
        }
    }

    /**
     * Set Dynamic Value into Email Template
     */
    protected function setDynamicValue($advisor, $mail_message){
        $profile_url = route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]);
        $profile_url = "<a href='" . $profile_url . "'>".$profile_url."</a>";
        $system = System::first();
        $mail_message = str_replace("{PLATFORM_DATE}", Carbon::now()->format($system->date_format), $mail_message);

        $mail_message = str_replace("{ADVISOR_BILLING_ID}", $advisor->billing_info->id ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_SUBSCRIPTION_PLAN}", $advisor->subscription_plan->name ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_PROFILE_URL}", $profile_url, $mail_message);
        return $mail_message;
    }
}
