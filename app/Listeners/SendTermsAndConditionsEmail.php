<?php

namespace App\Listeners;

use App\EmailTemplate;
use App\Events\Subscribe;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use App\TremsAndCondition;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use Illuminate\Notifications\Messages\MailMessage;

class SendTermsAndConditionsEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle(Subscribe $event)
    {
        $advisor = $event->user;
        $email_template = EmailTemplate::where('type', "terms_&_conditions_email")->first();
        

        $subject = $email_template->subject ?? "Terms & Conditions";
        $subject = $this->setDynamicValue($advisor, $subject);
        $footer = $email_template->footer ?? "";
        $mail_message = $email_template->body ?? "You Agree All Terms & Conditions";
        $mail_message = $this->setDynamicValue($advisor, $mail_message);
        
        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";
        
        $terms_conditions = TremsAndCondition::where('type', "signup")->orWhere('type', 'Sign up')->get();
        
        foreach($terms_conditions as $list){
            $mail_message = str_replace("{TERMS_AND_CONDITIONS_SIGN_UP}", $list->trems_and_condition ?? "", $mail_message);
            
            $param = [
                'mail_message'  => $mail_message,
                'mail_footer'   => $footer,
            ];
            if( isset($email_template->send_email) && $email_template->send_email==1){                
                // Save Communication Message
                $this->addCommunicationMessage($mail_message, $subject, $advisor->id,true);
                //SendSingleMail::dispatch($advisor, $subject, $param, "email.default",true)->delay(1);
                
                SendSingleMail::dispatch($advisor, $subject, $param, "email.default", $email_template->send_to_cc)->delay(1);
                
            }
           

            if($third_party_email_send && !empty($third_party_email) ){
                SendThirdPartyMail::dispatch($third_party_email, $subject, $param, "email.default_plain_body")->delay(1); 
            }
        }
        
    }

    /**
     * Set Dynamic Value into Email Template
     */
    protected function setDynamicValue($advisor, $mail_message){
        $system = System::first();
        $profile_url = route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]);
        $profile_url = "<a href='" . $profile_url . "'>".$profile_url."</a>";

        $mail_message = str_replace("{PLATFORM_DATE}", Carbon::now()->format($system->date_format), $mail_message);

        $mail_message = str_replace("{ADVISOR_PROFILE_URL}", $profile_url, $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_ID}", $advisor->billing_info->id ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_LAST_NAME}", $advisor->last_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_SUBSCRIPTION_PLAN}", $advisor->subscription_plan->name ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_COMPANY_NAME}", $advisor->billing_info->billing_company_name ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_COMPANY_NUMBER}", $advisor->billing_info->billing_company_fca_number ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_ADDRESS_LINE_1}", $advisor->billing_info->billing_address_line_one ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_ADDRESS_LINE_2}", $advisor->billing_info->billing_address_line_two ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_TOWN}", $advisor->billing_info->billing_town ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_COUNTY}", $advisor->billing_info->billing_country ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_POSTCODE}", $advisor->billing_info->billing_post_code ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_NUMBER_OF_SUBSCRIPTION_ACCOUNTS}", $advisor->no_of_subscription_accounts ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_POSTCODE_AREAS_COVERED}", $advisor->postcodesCovered(), $mail_message);
        $mail_message = str_replace("{ADVISOR_SUBSCIPTION_POSTCODES}", $advisor->postcodesCovered(Null, true), $mail_message);
        $mail_message = str_replace("{ADVISOR_DATE_AGREEING_TO_TERMS_AND_CONDITIONS}", $advisor->terms_and_condition_agree_date, $mail_message);
        
        return $mail_message;
    }
}
