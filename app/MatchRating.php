<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchRating extends Model
{
    public function plan(){
        return $this->belongsTo(SubscriptionPlan::class, "subscription_plan_id")->withTrashed();
    }
    public function service_offer(){
        return $this->belongsTo(ServiceOffer::class, "service_offer_id")->withTrashed();
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }

    public static function getSpecifyStarRatingRate($plan_id, $service_id){
        $data = self::where('subscription_plan_id', $plan_id)->where('service_offer_id', $service_id)->orderBy('id', 'desc')->first();
        if(!empty($data) ){
            $rate = $data->no_of_star / ($data->no_of_question ?? 1);
            return number_format($rate, 2, '.', '');
        }
        return 1;
    }

    public static function getNonSpecifyStarRatingRate($plan_id){
        $data = self::where('subscription_plan_id', $plan_id)->orderBy('id', 'desc')->first();
        if(!empty($data) ){
            $rate = $data->no_of_star / ($data->no_of_question ?? 1);
            return number_format($rate, 2, '.', '');
        }
        return 1;
    }
}
