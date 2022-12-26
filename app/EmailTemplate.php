<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $casts = [
        'send_email'    => "boolean",
        "send_to_cc"    => "boolean",
    ];
}
