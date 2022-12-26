<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\Http\Components\Traits\Communication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification
{
    use Queueable, Communication;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    private $advisor;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $advisor)
    {
        $this->token = $token;
        $this->advisor = $advisor;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $advisor = $this->advisor;
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

        $email_template = EmailTemplate::where('type', "password_reset_email")->first();

        $subject = $email_template->subject ?? "Advisor Password Reset";
        $footer = $email_template->footer ?? "";
        $mail_message = $this->setDynamicValue($url, $email_template->body ?? "");
        
        // Add Message Into Communication List
        $this->addCommunicationMessage($mail_message, $subject, $advisor->id, true);
        $msg_params = [
            "mail_message" => $mail_message, 
            "mail_footer" => $footer
        ];
        if(!empty($email_template)){
            return (new MailMessage)
            ->subject($subject)
            ->cc('notifications@regulatedadvice.co.uk')
            ->view("email.default", $msg_params);
        }
        return $this->sendDefaultMail($url);

        
    }

    /**
     * Send Default Mail While Template Missing
     */
    public function sendDefaultMail($url){
        return (new MailMessage)
            ->subject('Advisor Password Reset')
            ->cc('notifications@regulatedadvice.co.uk')
            ->line("Hello {$this->advisor->first_name} {$this->advisor->last_name} ")
            ->line("Please Reset Your Password For Login Advisor Dashboard")
            ->action('Click Here', $url)
            ->line('Thank you for using our services!');
    }

    /**
     * Set a callback that should be used when creating the reset password button URL.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

    /**
     * Set Dynamic Value into Email Template
     */
    protected function setDynamicValue($url, $mail_message){
        $action = "<a href='".$url."' style='background:#4a8bc2; color:#fff; padding:10px;text-decoration:none;'>Click Here</a>";
        $link = "<a href='".$url."'>$url</a>";
        $mail_message = str_replace("{reset_link}", $link, $mail_message);
        $mail_message = str_replace("[Click Here]", $action, $mail_message);
        return $mail_message;
    }
}
