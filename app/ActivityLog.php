<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public function advisor(){
        return $this->belongsTo(User::class, "advisor_id")->withTrashed();
    }
    public function admin(){
        return $this->belongsTo(Admin::class, "admin_id")->withTrashed();
    }
}
