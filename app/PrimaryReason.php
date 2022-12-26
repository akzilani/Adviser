<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrimaryReason extends Model
{
    use SoftDeletes;

    protected $casts = [
        "publication_status" => "boolean",
    ];

    public function location_post_codes(){
        return $this->hasMany(LocationPostCodes::class, "primary_region_id")->orderBy('short_name', 'ASC')->orderBy('full_name', 'ASC');
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
