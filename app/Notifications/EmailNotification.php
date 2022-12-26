<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailNotification extends Notification
{
    use Queueable;

    public $subject, $message, $page, $cc_enable, $thirt_party_cc_email;
    /**
     * Create a new notification instance.
     * @param message Will be Assiociative Array When will pass Page | Blade Page 
     * @param $page will be a Blade Page
     * @return void
     */
    public function __construct($subject, $message, $page = "", $cc_enable = true, $thirt_party_cc_email = "")
    {
        $this->subject      = $subject;
        $this->message      = $message;
        $this->page         = $page;
        $this->cc_enable    = $cc_enable;
        $this->thirt_party_cc_email = $thirt_party_cc_email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * @param messagewill be Array when Call a View Page
     */
    public function toMail($notifiable)
    {
        $params = is_array($this->message) ? $this->message : [];
        $mail_message = (new MailMessage)->subject($this->subject);
        if( $this->cc_enable ){
            $mail_message->cc('notifications@regulatedadvice.co.uk');
            //$mail_message->cc('shajushahjalal@gmail.com');
            //$mail_message->cc('nirjhor.aiub@gmail.com');
            //$mail_message->cc('faye.priestley@hotmail.co.uk');
        }
        if ( !empty($this->thirt_party_cc_email) && filter_var($this->thirt_party_cc_email, FILTER_VALIDATE_EMAIL)){
            $mail_message->cc($this->thirt_party_cc_email);
        }

        if( !empty($this->page) ){
            $mail_message->view($this->page, $params);
        }else{
            $mail_message->line(new HtmlString($this->message));
        }
        return $mail_message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
