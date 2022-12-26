<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes; 
    
    protected $casts = [
        "publication_status" => "boolean",
    ];

    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id')->withTrashed();
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
