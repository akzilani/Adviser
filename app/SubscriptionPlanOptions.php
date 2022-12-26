<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanOptions extends Model
{
    public function subscription_plan(){
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id')->withTrashed();
    }
}
