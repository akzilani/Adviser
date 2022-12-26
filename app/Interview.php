<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id')->withTrashed();
    }
    public function interview_question(){
        return $this->belongsTo(InterviewQuestion::class, 'interview_question_id');
    }

}
