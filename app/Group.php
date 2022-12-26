<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $casts = [
        "is_admin"  => "boolean",
    ];

    public function group_accesses(){
        return $this->hasOne(GroupAccess::class, "group_id");
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, "group_id");
    }
}
