<?php

namespace App\Jobs;

use App\Notifications\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendThirdPartyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email, $subject, $message, $page;
    /**
     * Create a new job instance.
     * @param message Will be Assiociative Array When will pass Page | Blade Page 
     * @param $page will be a Blade Page
     * @return void
     */
    public function __construct($email, $subject, $message, $page = "")
    {
        $this->email        = $email;
        $this->subject      = $subject;
        $this->message      = $message;
        $this->page         = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::route("mail", $this->email)
            ->notify(new EmailNotification($this->subject, $this->message, $this->page));
    }
}
