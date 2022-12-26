<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $casts = [
        'store_data' => 'boolean', 
        'call_permission' => 'boolean', 
        'email_permission' => 'boolean', 
        'text_permission' => 'boolean',
        'is_seen' => 'boolean'
    ];

    public function serviceOffer(){
        return $this->belongsTo(ServiceOffer::class, 'service_offer_id')->withTrashed();
    }

}
