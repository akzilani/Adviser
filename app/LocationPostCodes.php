<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationPostCodes extends Model
{
    use SoftDeletes;
    protected $casts = [
        "publication_status" => "boolean",
    ];

    public function primary_reasons(){
        return $this->belongsTo(PrimaryReason::class, "primary_region_id")->orderBy('position', 'ASC');
    }

    public function primary_reasons_all(){
        return $this->belongsTo(PrimaryReason::class, "primary_region_id")->orderBy('position', 'ASC')->withTrashed();
    }
    
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by");
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by");
    }
}
