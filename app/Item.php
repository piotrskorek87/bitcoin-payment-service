<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;
use App\Order;

class Item extends Model
{
    public $quantity = null;

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function photo()
    {
    	return $this->hasMany(Photo::class);
    }

    public function thumbnail()
    {
    	return $this->photo()->where('thumbnail', 1)->first();
    }

    public function hasLowStock(){
        if ($this->outOfStock()) {
            return false;
        }

        return (bool)($this->stock <= 5);
    }

    public function outOfStock(){
        return $this->stock === 0;
    }

    public function inStock(){
        $this->stock >= 5;
    }

    public function hasStock($quantity){
        return $this->stock >= $quantity;
    }

    public function order(){
        return $this->belongsToMany(Order::class, 'orders_products')->withPivot('quantity');
    }
}
