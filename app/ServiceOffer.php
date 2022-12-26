<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOffer extends Model
{
    use SoftDeletes;

    protected $casts = [
        "publication_status" => "boolean",
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }

    public function ans_questions(){
        return $this->hasMany(AdvisorQuestion::class, "service_offer_id")->where("publication_status", true)->orderBy('id', 'DESC');
    }

    public function ans_public_questions(){
        return $this->hasMany(AdvisorQuestion::class, "service_offer_id")->where("publication_status", true)->where('visibility', 'public')->orderBy('id', 'DESC');
    }

    public function getAvgMatchRating(){
        
    }
}
