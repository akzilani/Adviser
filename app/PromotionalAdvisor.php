<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionalAdvisor extends Model
{
    protected $casts = [
        'publication_status'    => "boolean",
    ];

    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id');
    }
}
