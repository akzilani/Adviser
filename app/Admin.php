<?php

namespace App;

use App\Notifications\ResetAdminPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_developer'  => 'array',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, "group_id");
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, "created_by");
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, "updated_by");
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetAdminPasswordNotification($token));
    }
}
