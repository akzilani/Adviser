<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    public function advisor(){
        return $this->belongsTo(User::class, 'bidder_id')->withTrashed();
    }
}
