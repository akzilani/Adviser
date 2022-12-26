<?php

namespace App\Listeners;

use App\AuctionBid as AppAuctionBid;
use App\EmailTemplate;
use App\Events\AuctionBid;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendMail;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLowerBidEmail
{
    use Communication;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  AuctionBid  $event
     * @return void
     */
    public function handle(AuctionBid $event)
    {
        $auction = $event->auction;
        $email_template = EmailTemplate::where('type', "auction_outbid_email")->first();
        
        $subject = $email_template->subject ?? "Auction Outbid";
        $raw_mail_body = $email_template->body ?? "You have been outbid";
        $footer = $email_template->footer ?? "Thank You.";
        $advisor_arr = AppAuctionBid::where('auction_id', $auction->id)->where('bidder_id', '!=', $auction->max_bidder_id)->select("bidder_id as advisor_id")->get()->pluck('advisor_id')->toArray();  
        
        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";

        foreach($advisor_arr as $advisor_id){
            $advisor = User::find($advisor_id);
            $subject = $this->setDynamicValue($auction, $advisor, $subject);
            $mail_body = $this->setDynamicValue($auction, $advisor, $raw_mail_body);
            $message = ["mail_message" => $mail_body, "mail_footer" => $footer];            

            if( isset($email_template->send_email) && $email_template->send_email){
                // Save Communication Message
                $this->addCommunicationMessage($mail_body, $subject, $advisor->id, true);
    
                SendSingleMail::dispatch($advisor, $subject, $message, "email.auction", $email_template->send_to_cc)->delay(1); 
            }

            if($third_party_email_send && !empty($third_party_email) ){
                SendThirdPartyMail::dispatch($third_party_email, $subject, $message, "email.auction_plain_body")->delay(1); 
            }
        }
    }

    /**
     * Set Dynamic Value into Email Template
     */
    protected function setDynamicValue($auction, $advisor, $mail_message){
        
        $system = System::first();
        $mail_message = str_replace("{PLATFORM_DATE}", Carbon::now()->format($system->date_format), $mail_message);

        $mail_message = str_replace("{ADVISOR_BILLING_ID}", $advisor->billing_info->id ?? "N/A", $mail_message);
        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("{AUCTION_POSTCODE}", $auction->post_code, $mail_message);
        return $mail_message;
    }
}
