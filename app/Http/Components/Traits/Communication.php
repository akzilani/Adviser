<?php

namespace App\Http\Components\Traits;

use App\Communication as AppCommunication;

trait Communication{

    public function addCommunicationMessage($message, $subject = "", $advisor_id = Null, $plain_text_message = false){
        if( !$plain_text_message ){
            $message = json_encode($message);
        }
        $communication = new AppCommunication();
        $communication->advisor_id  = $advisor_id;
        $communication->subject     = $subject;
        $communication->message     = $message;
        $communication->plain_text_message = $plain_text_message;
        $communication->publication_status = true;
        $communication->save();        
    }
}