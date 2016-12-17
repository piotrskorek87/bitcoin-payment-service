<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Block_io_account;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function block_io_account(){
        return $this->hasOne(Block_io_account::class);
    }

    
}
