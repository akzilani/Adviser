<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailNotificationWithoutCC extends Notification
{
    use Queueable;

    public $subject, $message, $page;
    /**
     * Create a new notification instance.
     * @param message Will be Assiociative Array When will pass Page | Blade Page 
     * @param $page will be a Blade Page
     * @return void
     */
    public function __construct($subject, $message, $page = "")
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->page    = $page;
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
        if( !empty($this->page) ){
            $params = is_array($this->message) ? $this->message : [];
            return (new MailMessage)
                ->subject($this->subject)
                ->view($this->page, $params);
        }

        return (new MailMessage)
            ->subject($this->subject)
            ->line(new HtmlString($this->message));
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
