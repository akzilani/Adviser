<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisorMarketing extends Model
{
    public function serviceOffer(){
        return $this->belongsTo(ServiceOffer::class, 'service_offer_id')->withTrashed();
    }
}
