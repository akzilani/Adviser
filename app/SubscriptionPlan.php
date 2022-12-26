<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use SoftDeletes;

    protected $casts = [
        "index_search_list"     => "boolean",
        "auction_room_access"   => "boolean",
        "qualified_leads"       => "boolean",
        "per_lead_tbc"          => "boolean",
        "account_manager"       => "boolean",
        "office_manager"        => "boolean",
        "publication_status"    => "boolean",
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
    public function advisors(){
        return $this->hasMany(User::class, 'subscription_plan_id');
    }
    public function subscription_plan_options(){
        return $this->hasMany(SubscriptionPlanOptions::class, 'subscription_plan_id')->orderBy('position', 'ASC');
    }
    public function subscription_plan_active_options(){
        return $this->hasMany(SubscriptionPlanOptions::class, 'subscription_plan_id')->where('status', 'active')->orderBy('position', 'ASC');
    }
    public function profession(){
        return $this->belongsTo(Profession::class, "profession_id")->withTrashed();
    }
}
