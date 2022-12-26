<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\Http\Components\Traits\Communication;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class EmailVerification extends Notification
{
    use Queueable, Communication;
    private $advisor;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($advisor)
    {
        $this->advisor = $advisor;
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
     */
    public function toMail($notifiable)
    {
        $advisor = $this->advisor;
        $verificationUrl = $this->verificationUrl($notifiable);
        $email_template = EmailTemplate::where('type', "account_verification_email")->first();

        $subject = $email_template->subject ?? "Please verify your email address";
        $footer = $email_template->footer ?? "";
        $mail_message = $this->setDynamicValue($advisor, $verificationUrl, $email_template->body ?? "");
        $msg_params = [
            "mail_message" => $mail_message, 
            "mail_footer" => $footer
        ];
        
        // Add Message into Collunivation List
        //$this->addCommunicationMessage($mail_message, $subject, $advisor->id, true);
        
        /*if(!empty($email_template)){
            return (new MailMessage)
            ->subject($subject)
            ->cc('notifications@regulatedadvice.co.uk')
            ->view("email.default", $msg_params);
        }*/
        //return $this->sendDefaultMail($verificationUrl);
        
        //New Naimur
        // if(!empty($email_template)){
            if($email_template->send_email == 1){
            return (new MailMessage)
            ->subject($subject)
            ->cc('notifications@regulatedadvice.co.uk')
            ->view("email.default", $msg_params);
            $this->addCommunicationMessage($mail_message, $subject, $advisor->id, true);
            return $this->sendDefaultMail($verificationUrl);
        }



        
    }

    /**
     * Default Mail Feature
     */
    public function sendDefaultMail($verificationUrl ){
        $account_activation_message = '<h3>Hello!</h3> Welcome ' . $this->advisor->first_name . ' ' .$this->advisor->last_name.'<br><br><br>';
        $account_activation_message .= '<a href="'. $verificationUrl .'" style="background:#4a8bc2; color:#fff; padding:10px 15px;" > Activate Your Account </a><br><br>';
        $account_activation_message .= 'Thank you for using Regulated Advice!<br>Regards,<br>Regulated Advice';
        $this->addCommunicationMessage($account_activation_message, "Account activation email", $this->advisor->id, true);

        $message =  (new MailMessage)
                    ->subject("Please verify your email address")
                    ->line('<h3>Hello!</h3> Welcome ' . $this->advisor->first_name . ' ' .$this->advisor->last_name)
                    ->action('Activate Your Account', $verificationUrl )
                    ->line('Thank you for using Regulated Advice!');
        return $message;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
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

    /**
     * Set Dynamic Value into Email Template
     */
    protected function setDynamicValue($advisor, $url, $mail_message){
        $action = "<br><a href='".$url."' style='background:#01a9ac; padding:8px 15px; color:#fff; text-decoration:none;line-height: 40px;'>Click Here</a>";
        $action2 = "<br><a href='".$url."' style='background:#01a9ac; padding:8px 15px; color:#fff; text-decoration:none;line-height: 40px;'>Verify Now</a>";
        $verification_link = "<a href='".$url."'>'".$url."'</a>";
        $mail_message = str_replace("{ADVISOR_FIRST_NAME}", $advisor->first_name, $mail_message);
        $mail_message = str_replace("[verification link]", $verification_link, $mail_message);
        $mail_message = str_replace("[Click Here]", $action, $mail_message);
        $mail_message = str_replace("[Verify Now]", $action2, $mail_message);
        return $mail_message;
    }
}
