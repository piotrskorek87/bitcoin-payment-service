<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Payment extends Model
{
    protected $fillable = [
    	'failed',
    	'transaction_id',
    ];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }
}
