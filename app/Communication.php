<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communication extends Model
{
    use SoftDeletes; 
    
    protected $casts = [
        "publication_status" => "boolean",
        "plain_text_message" => "boolean",
    ];

    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }

    public function getForeignData($foreign_table, array $find_id_arr){
        $data_arr = [];
        if($foreign_table == "service_offers"){
            $data_arr = ServiceOffer::whereIn('id', $find_id_arr)->get()->pluck('name')->toArray();
        }elseif($foreign_table == "fund_size"){
            $data_arr = FundSize::whereIn('id', $find_id_arr)->get()->pluck('name')->toArray();
        }
        return implode(", ",$data_arr);
    }
}
