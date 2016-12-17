<?php 

namespace App\Events;

use App\Order;
use App\Basket\Basket;

class OrderWasCreated extends Event
{

	public $order;
	public $basket;

	public function __construct(Order $order, Basket $basket)
	{
		$this->order = $order;
		$this->basket = $basket;

	}
}