<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TremsAndCondition extends Model
{

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
}
