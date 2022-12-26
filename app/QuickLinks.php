<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuickLinks extends Model
{
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
}
