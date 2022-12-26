<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisorBlog extends Model
{
    protected $casts = [
        "publication_status" => "boolean",
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, "admin_id")->withTrashed();
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
