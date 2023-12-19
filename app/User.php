<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        
        'name', 'email', 'password',
        
    ];

    protected $hidden = [
        
        'password', 'remember_token',

    ];

    protected $casts = [
        
        'email_verified_at' => 'datetime',

    ];

    public function roles()
    {
        
        return $this->belongsToMany('App\Role','model_has_roles','model_id','role_id');

    }

    public function transactions(){

        return $this->hasMany(Transaction::class);

    }

}
