<?php

namespace App\Listeners;

use App\EmailTemplate;
use App\Events\LeadAssign;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendLeadAssignEmail
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
     * @param  LeadAssign  $event
     * @return void
     */
    public function handle(LeadAssign $event)
    {
        $lead = $event->lead;   
        // dd($lead);     
        if($event->mail_type == "match me"){
            $email_template = EmailTemplate::where('type', "match_me_lead_referral")->first();
            $advisor = User::find($lead->advisor_id);
        }else{
            $email_template = EmailTemplate::where('type', "search_local_lead_referral")->first();
            $advisor = User::whereIn('id', $lead->invite_advisors)->first();
        }

        $subject = $email_template->subject ?? "Regulated Advice - Congratulations! You just acquired a new lead";
        $subject = $this->setDynamicValue($lead, $advisor, $subject);
        $mail_body = $email_template->body ?? "Congratulations! You just acquired a new lead";
        $mail_body = $this->setDynamicValue($lead, $advisor, $mail_body);
        $footer = $email_template->footer ?? "";
        $message = ["mail_message" => $mail_body, "mail_footer" => $footer, "lead" => $lead];

        if( isset($email_template->send_email) && $email_template->send_email == 1){
            // Save Communication Message
            $this->addCommunicationMessage($mail_body, $subject, $advisor->id, true);            
            SendSingleMail::dispatch($advisor, $subject, $message, "email.lead", $email_template->send_to_cc)->delay(1);
        }

        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";
        
        if($third_party_email_send && !empty($third_party_email) ){
            SendThirdPartyMail::dispatch($third_party_email, $subject, $message, "email.lead_plain_body")->delay(1);
        }
    }

    /**
     * Set or Append Dynamic Value into Mail Message
     */
    protected function setDynamicValue($lead, $advisor, $mail_message){
        $profile_url = route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]);
        $profile_url = "<a href='" . $profile_url . "'>".$profile_url."</a>";
        $assign_advisor = $advisor->first_name . ' '.$advisor->last_name;

        $system = System::first();
        $mail_message = str_replace("{PLATFORM_DATE}", Carbon::now()->format($system->date_format), $mail_message);
        $mail_message = str_replace("{LEAD_TYPE}", ucwords($lead->type), $mail_message);
        $mail_message = str_replace("{LEAD_ASSIGNED_ADVISOR}", ucwords($assign_advisor), $mail_message);
        $mail_message = str_replace("{LEAD_FIRST_NAME}", $lead->name, $mail_message);
        $mail_message = str_replace("{LEAD_LAST_NAME}", $lead->last_name ?? "", $mail_message);
        $mail_message = str_replace("{LEAD_EMAIL}", $lead->email, $mail_message);
        $mail_message = str_replace("{LEAD_TELEPHONE_NUMBER}", $lead->phone, $mail_message);
        $mail_message = str_replace("{LEAD_POSTCODE}", $lead->post_code, $mail_message);
        $mail_message = str_replace("{LEAD_FUND_VALUE}", $lead->fund_size->name ?? "", $mail_message);
        $mail_message = str_replace("{LEAD_AREAS_OF_ADVICE}", $lead->service_offered(), $mail_message);
        $mail_message = str_replace("{LEAD_QUESTION}", $lead->question, $mail_message);
        $mail_message = str_replace("{LEAD_COMMUNICATION_TYPE}", $lead->communication_type, $mail_message);
        $mail_message = str_replace("{LEAD_DATE}", $lead->date, $mail_message);
        $mail_message = str_replace("{LEAD_ID}", $lead->id, $mail_message);
        return $mail_message;
    }
}
