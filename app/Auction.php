<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use SoftDeletes;
    
    protected $casts = [
        'primary_region_id' => 'array',
        'service_offer_id'  => 'array',
    ];

    public function lead(){
        return $this->belongsTo(Leads::class, 'lead_id')->withTrashed();
    }
    public function bids(){
        return $this->hasMany(AuctionBid::class, 'auction_id')->orderBy('bid_price', 'DESC');
    }
    public function max_bidder(){
        return $this->belongsTo(User::class, 'max_bidder_id')->withTrashed();
    }    
    public function createdBy(){
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
    public function fund_size(){
        return $this->belongsTo(FundSize::class, "fund_size_id")->withTrashed();
    }
    public function bid_win(){
        return $this->hasOne(AuctionBid::class, "auction_id")->orderBy('bid_price', 'DESC');
    }

    public function service_offered(){
        $data_arr = [];
        if( is_array($this->service_offer_id) ){
            $data_arr = ServiceOffer::whereIn('id', $this->service_offer_id)->get()->pluck('name')->toArray();
        }
        return implode(', ', $data_arr);
    }

    public function primary_reason(){
        $primary_reason = $this->primary_region_id;
        if( !is_array($primary_reason) ){
            $primary_reason = (array)$primary_reason;
        }
        $all_reasons = PrimaryReason::whereIn('id', $primary_reason)->select('name')->get()->pluck('name');
        $all_reasons = $all_reasons->toArray();
        return implode(",  ",$all_reasons);
    }
}
