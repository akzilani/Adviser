<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisorBillingInfo extends Model
{
    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id', 'id');
    }
}
