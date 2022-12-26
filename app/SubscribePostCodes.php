<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribePostCodes extends Model
{
    use SoftDeletes;
    protected $casts = [
        "publication_status" => "boolean",
    ];

    public function subscribe_primary_reasons(){
        return $this->belongsTo(SubscribePrimaryReason::class, "primary_region_id")->orderBy('position', 'ASC');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
}
