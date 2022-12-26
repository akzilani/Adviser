<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by");
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by");
    }

    public static function getPage($name){
        return self::where('page_name', $name)->orderBy("id", "DESC")->first();
    }
}
