<?php

namespace App\Listeners;

use App\EmailTemplate;
use App\Events\AuctionCancel;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAuctionCancelEmail
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
     * @param  AuctionCancel  $event
     * @return void
     */
    public function handle(AuctionCancel $event)
    {
        $auction = $event->auction;
        $email_template = EmailTemplate::where('type', "auction_cancelled_email")->first();

        if( isset($email_template->send_email) && $email_template->send_email){
            foreach($event->advisors as $advisor){
                $subject = $email_template->subject ?? "Auction Notification";
                $mail_body = $email_template->body ?? null;
                $footer = $email_template->footer ?? "";
                $mail_body = $mail_body ?? ($advisor->first_name." ". $advisor->first_name."<br> A new auction has been published. Auction BID time ". Carbon::parse($auction->start_time)->format('d-F, Y h:i A') . ' To ' . Carbon::parse($auction->end_time)->format('d-F, Y h:i A') . "<br> To check the auction visit the link  <a href='".route('advisor.auction.list')."'>".route('advisor.auction.list')."</a><br><b>Thank You.</b>");
                $mail_body = $this->setDynamicValue($auction, $advisor, $mail_body);
                $subject = $this->setDynamicValue($auction, $advisor, $subject);
    
                // Save Communication Message
                $this->addCommunicationMessage($mail_body, $subject, $advisor->id, true);
                $message = ["mail_message" => $mail_body, 'mail_footer' => $footer];
                SendSingleMail::dispatch($advisor, $subject, $message, "email.auction", $email_template->send_to_cc)->delay(1);
            }
        }

        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";

        if($third_party_email_send && !empty($third_party_email) ){
            foreach($event->advisors as $advisor){
                $subject = $email_template->subject ?? "Auction Notification";
                $mail_body = $email_template->body ?? null;
                $footer = $email_template->footer ?? "";
                $mail_body = $mail_body ?? ($advisor->first_name." ". $advisor->first_name."<br> A new auction has been published. Auction BID time ". Carbon::parse($auction->start_time)->format('d-F, Y h:i A') . ' To ' . Carbon::parse($auction->end_time)->format('d-F, Y h:i A') . "<br> To check the auction visit the link  <a href='".route('advisor.auction.list')."'>".route('advisor.auction.list')."</a><br><b>Thank You.</b>");
                $mail_body = $this->setDynamicValue($auction, $advisor, $mail_body);
                $subject = $this->setDynamicValue($auction, $advisor, $subject);
    
                $message = ["mail_message" => $mail_body, 'mail_footer' => $footer];
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

        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_LAST_NAME}", $advisor->last_name, $mail_message);
        $mail_message = str_replace("{ADVISOR_BILLING_ID}", $advisor->billing_info->id ?? "N/A", $mail_message);
        $mail_message = str_replace("{AUCTION_POSTCODE}", $auction->post_code, $mail_message);
        $mail_message = str_replace("{AUCTION_PRIMARY_REGION}", $auction->primary_reason(), $mail_message);
        $mail_message = str_replace("{AUCTION_TYPE}", ucwords($auction->type), $mail_message);
        $mail_message = str_replace("{AUCTION_AREAS_OF_ADVICE}", $auction->service_offered(), $mail_message);
        $mail_message = str_replace("{AUCTION_FUND_SIZE}", $auction->fund_size->name ?? "", $mail_message);
        $mail_message = str_replace("{AUCTION_COMMUNICATION_TYPE}", $auction->communication_type, $mail_message);
        $mail_message = str_replace("{AUCTION_QUESTION}", $auction->question, $mail_message);
        $mail_message = str_replace("{AUCTION_START_DATE}", Carbon::parse($auction->start_time)->format($system->date_format), $mail_message);
        $mail_message = str_replace("{AUCTION_START_TIME}", Carbon::parse($auction->start_time)->format('h:i A'), $mail_message);
        $mail_message = str_replace("{AUCTION_END_TIME}", $auction->duration, $mail_message);
        $mail_message = str_replace("{AUCTION_RESERVE_PRICE}", $auction->base_price, $mail_message);        
        return $mail_message;
    }
}
