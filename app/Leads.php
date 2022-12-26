<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leads extends Model
{
    use SoftDeletes;

    protected $casts = [
        "publication_status"=> "boolean",
        'service_offer_id'  => "array",
        'invite_advisors'  => "array", // Choose Advisor
    ];

    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by");
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by");
    }

    public function fund_size(){
        return $this->belongsTo(FundSize::class, "fund_size_id");
    }

    public function auction(){
        return $this->hasOne(Auction::class, 'lead_id');
    }


    public function service_offered(){
        $data_arr = [];
        if( is_array($this->service_offer_id) ){
            $data_arr = ServiceOffer::whereIn('id', $this->service_offer_id)->get()->pluck('name')->toArray();
        }else{
            $data_arr = ServiceOffer::where('id', $this->service_offer_id)->get()->pluck('name')->toArray();
        }
        return implode(', ', $data_arr);
    }

    public function choose_advisor(){
        $choosen_advisor = "";
        $advisors = User::whereIn('id', $this->invite_advisors ?? [])->get();
        foreach($advisors as $advisor){
            $choosen_advisor .= $advisor->first_name . ' ' . $advisor->last_name ;
        }
        return trim($choosen_advisor);
    }
}
