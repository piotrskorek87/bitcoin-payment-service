<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
// use App\Item;

class Customer extends Model
{
    protected $fillable = [
    	'email',
    	'name',
    ];

    public function orders(){
    	return $this->hasMany(Order::class);
    }
}
