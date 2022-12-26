<?php

namespace App\Listeners;

use App\EmailTemplate;
use App\Events\LeadInvitation;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendLeadInvitationEmail
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
     * @param  LeadInvitation  $event
     * @return void
     */
    public function handle(LeadInvitation $event)
    {
        $lead = $event->lead;
        $advisor_arr = $lead->invite_advisors;
        if($lead == "match me"){
            $email_template = EmailTemplate::where('type', "match_me_lead_notification_email")->first();
        }else{
            $email_template = EmailTemplate::where('type', "search_local_notification_email")->first();
        }

        $subject = $email_template->subject ?? "Regulated Advice - {ADVISOR_PROFILE_NAME}";
        $mail_body = $email_template->body ?? "A new Lead has been created";
        $footer = $email_template->footer ?? "";
        if( isset($email_template->send_email) && $email_template->send_email){
            foreach($advisor_arr as $advisor_id){
                $advisor = User::find($advisor_id);
                $subject = $this->setDynamicValue($lead, $advisor, $subject);            
                $mail_body = $this->setDynamicValue($lead, $advisor, $mail_body);
    
                // Save Communication Message
                $this->addCommunicationMessage($mail_body, $subject, $advisor->id, true);
    
                $message = ["mail_message" => $mail_body, "mail_footer" => $footer, "lead" => $lead];
                SendSingleMail::dispatch($advisor, $subject, $message, "email.lead", $email_template->send_to_cc)->delay(1);
            }
        }
        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";
        
        if($third_party_email_send && !empty($third_party_email) ){
            foreach($advisor_arr as $advisor_id){
                $advisor = User::find($advisor_id);
                $subject = $this->setDynamicValue($lead, $advisor, $subject);            
                $mail_body = $this->setDynamicValue($lead, $advisor, $mail_body);
    
                $message = ["mail_message" => $mail_body, "mail_footer" => $footer, "lead" => $lead];                
                SendThirdPartyMail::dispatch($third_party_email, $subject, $message, "email.lead_plain_body")->delay(1);
            }
        }
        
    }

    
    /**
     * Set or Append Dynamic Value into Mail Message
     */
    protected function setDynamicValue($lead, $advisor, $mail_message){
        $profile_url = route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]);
        $profile_url = "<a href='" . $profile_url . "'>".$profile_url."</a>";
        $advisor_name = $advisor->first_name . ' '. $advisor->last_name;

        $system = System::first();
        $mail_message = str_replace("{PLATFORM_DATE}", Carbon::now()->format($system->date_format), $mail_message);

        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_LAST_NAME}", $advisor->last_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_PROFILE_NAME}", $advisor->firm_details->profile_name ?? "", $mail_message);
        $mail_message = str_replace("{ADVISORS_PROFILE_URL}", $profile_url, $mail_message);
        $mail_message = str_replace("{ADVISOR}", $advisor_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_ADVISOR_PROFESSION}", $advisor->profession->name ?? "", $mail_message);
        $mail_message = str_replace("{LEAD_POSTCODE}", $lead->post_code, $mail_message);
        $mail_message = str_replace("{LEAD_FIRST_NAME}", $lead->name, $mail_message);
        $mail_message = str_replace("{LEAD_LAST_NAME}", $lead->last_name ?? "", $mail_message);
        $mail_message = str_replace("{LEAD_EMAIL}", $lead->email, $mail_message);
        $mail_message = str_replace("{LEAD_TELEPHONE_NUMBER}", $lead->phone, $mail_message);
        $mail_message = str_replace("{LEAD_AREAS_OF_ADVICE}", $lead->service_offered(), $mail_message);
        $mail_message = str_replace("{LEAD_FUND_VALUE}", $lead->fund_size, $mail_message);
        $mail_message = str_replace("{LEAD_QUESTION}", $lead->question, $mail_message);
        $mail_message = str_replace("{LEAD_COMMUNICATION_TYPE}", $lead->communication_type, $mail_message);
        return $mail_message;
    }
}
