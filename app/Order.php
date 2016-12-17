<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;
use App\Item;
use App\Payment;
use App\Customer;

class Order extends Model
{
    protected $fillable = [
    	'hash',
        'bitcoin_address',
    	'total',
        'totalBTC',
        'BTC_received',
    	'paid',
        'checked',
    	'address_id',
    ];

    public function address()
    {
    	return $this->belongsTo(Address::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
    	return $this->belongsToMany(Item::class, 'orders_products')->withPivot('quantity');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
