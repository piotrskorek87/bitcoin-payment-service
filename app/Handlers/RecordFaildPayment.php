<?php 

namespace App\Handlers;

use App\Handlers\Contracts\HandlerInterface;

class RecordFaildPayment implements HandlerInterface
{
	public function handle($event)
	{
		$event->order->payment()->create([
			'failed' => true,
			'transaction_id' => null,
		]);
	}
}