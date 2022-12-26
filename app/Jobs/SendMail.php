<?php

namespace App\Jobs;

use App\Notifications\EmailNotification;
use App\Notifications\EmailNotificationWithoutCC;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $advisor_arr = [], $subject, $message, $page, $without_cc;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $advisor_arr, $subject, $message, $page= "", $without_cc = false)
    {
        $this->advisor_arr  = $advisor_arr;
        $this->subject      = $subject;
        $this->message      = $message;
        $this->page         = $page;
        $this->without_cc   = $without_cc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->advisor_arr as $advisor_id){
            $advisor = User::find($advisor_id);
            if($this->without_cc){
                $advisor->notify(new EmailNotificationWithoutCC($this->subject, $this->message, $this->page));
            }else{
                $advisor->notify(new EmailNotification($this->subject, $this->message, $this->page));
            }
            
            
        }
    }
}
