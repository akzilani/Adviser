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

class SendSingleMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public $advisor, $subject, $message, $page;
    
    public $advisor, $subject, $message, $page, $cc;
    
    /**
     * Create a new job instance.
     * @param message Will be Assiociative Array When will pass Page | Blade Page 
     * @param $page will be a Blade Page
     * @return void
     */
    public function __construct($advisor, $subject, $message, $page = "", $cc = true)
    {
        $this->advisor      = $advisor;
        $this->subject      = $subject;
        $this->message      = $message;
        $this->page         = $page;
        $this->cc           = $cc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $advisor = $this->advisor;        
        $advisor->notify(new EmailNotification($this->subject, $this->message, $this->page, $this->cc));
    }
}
