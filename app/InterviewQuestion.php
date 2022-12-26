<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewQuestion extends Model
{
    use SoftDeletes;

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by");
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by");
    }
}
