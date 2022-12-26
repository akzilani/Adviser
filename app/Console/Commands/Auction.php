<?php

namespace App\Console\Commands;

use App\Auction as AppAuction;
use App\EmailTemplate;
use App\Events\AuctionCreated;
use App\Http\Components\Traits\Communication;
use App\Jobs\SendSingleMail;
use App\Jobs\SendThirdPartyMail;
use App\System;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Auction extends Command
{
    use Communication;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auction Status Check & Change';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->changeAuctionStatusRunning();
        $this->changeAuctionStatusComplete();
    }

    /**
     * Change Status of Auction as Running
     */
    protected function changeAuctionStatusRunning(){
        $auctions = AppAuction::where('status', '!=', 'running')->where('status', '!=', "cancelled")->where('start_time', '<=', now())->where('end_time', '>=', now())->get();
        foreach($auctions as $auction){
            $auction->status = 'running';
            $auction->save();
        }
    }

    /**
     * Change Status of Auction as Completed
     */
    protected function changeAuctionStatusComplete(){
        $auctions = AppAuction::where('status', '!=', 'completed')->where('status', '!=', "cancelled")->where( 'end_time', '<', now())->get();
        foreach($auctions as $auction){
            $this->completeAuction($auction);
        }
        
    }

    /**
     * Complete Auction Process
     */
    public function completeAuction($auction, $buy_out_mail = false){
        $auction->status = 'completed';
        $auction->end_time = now();
        $auction->save();

        $advisor = $auction->max_bidder ?? "";
        if( !empty($advisor) ){
            $email_template = EmailTemplate::where('type', "auction_win_email")->first();

            if( isset($email_template->send_email) && $email_template->send_email){
                $subject = $email_template->subject ?? "Auction Win";
                $subject = $this->setDynamicValue($auction, $advisor, $subject);
                $mail_body = $email_template->body ?? "Congratulations! You are winner & You won a Lead";
                $mail_body = $this->setDynamicValue($auction, $advisor, $mail_body);
                $footer = $email_template->footer ?? "";
                $message = ["mail_message" => $mail_body, 'mail_footer' => $footer];
                SendSingleMail::dispatch($advisor, $subject, $message, "email.auction")->delay(1);

            }
            
            $third_party_email_send = $email_template->third_party_email_send ?? false;
            $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";
            
            if($third_party_email_send && !empty($third_party_email) ){

                $subject = $email_template->subject ?? "Auction Win";
                $subject = $this->setDynamicValue($auction, $advisor, $subject);
                $mail_body = $email_template->body ?? "Congratulations! You are winner & You won a Lead";
                $mail_body = $this->setDynamicValue($auction, $advisor, $mail_body);
                $message = ["mail_message" => $mail_body, 'mail_footer' => $footer];
                SendThirdPartyMail::dispatch($third_party_email, $subject, $message, "email.auction_plain_body")->delay(1);
            }

            if($buy_out_mail){
                $this->sendActiveButOutMail($auction, $advisor);
            }

        }
    }

    /**
     * Send Buy Out Active Info Mail
     */
    public function sendActiveButOutMail($auction, $advisor){
        $email_template = EmailTemplate::where('type', "buy_out_activated_mail")->first();
        // Email to Advisor
        if( isset($email_template->send_email) && $email_template->send_email){
            $subject = $email_template->subject ?? "Auction Buy Out Activation";
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

        // Third party Email
        $third_party_email_send = $email_template->third_party_email_send ?? false;
        $third_party_email = isset($email_template->third_party_email) && $email_template->third_party_email ? ($email_template->third_party_email ?? "") : "";
        
        if($third_party_email_send && !empty($third_party_email) ){
            $subject = $email_template->subject ?? "Auction Buy Out Activation";
            $mail_body = $email_template->body ?? null;
            $footer = $email_template->footer ?? "";
            $mail_body = $mail_body ?? ($advisor->first_name." ". $advisor->first_name."<br> A new auction has been published. Auction BID time ". Carbon::parse($auction->start_time)->format('d-F, Y h:i A') . ' To ' . Carbon::parse($auction->end_time)->format('d-F, Y h:i A') . "<br> To check the auction visit the link  <a href='".route('advisor.auction.list')."'>".route('advisor.auction.list')."</a><br><b>Thank You.</b>");
            $mail_body = $this->setDynamicValue($auction, $advisor, $mail_body);
            $subject = $this->setDynamicValue($auction, $advisor, $subject);

            // Save Communication Message
            $message = ["mail_message" => $mail_body, 'mail_footer' => $footer];
            SendThirdPartyMail::dispatch($third_party_email, $subject, $message, "email.auction_plain_body")->delay(1);
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
        $mail_message = str_replace("{AUCTION_START_DATE}", Carbon::parse($auction->start_time)->format('Y-m-d'), $mail_message);
        $mail_message = str_replace("{AUCTION_START_TIME}", Carbon::parse($auction->start_time)->format('h:i A'), $mail_message);
        $mail_message = str_replace("{AUCTION_END_TIME}", Carbon::parse($auction->end_time)->diff()->format('%H Hour: %I Minute: %S Second'), $mail_message);
        $mail_message = str_replace("{AUCTION_RESERVE_PRICE}", $auction->base_price, $mail_message);     

        return $mail_message;
    }
}
