<?php 

namespace App\Basket;

use App\Support\Storage\SessionStorage;
use App\Item;
use App\Basket\Exceptions\QuantityExceededException;
use Session;

class Basket
{
	protected $storage;
	protected $item;

	public function __construct(SessionStorage $storage, Item $item){
		$this->storage = $storage;
		$this->item = $item;
	}

	public function add(Item $item, $quantity){
		if($this->has($item)){
			$quantity = $this->get($item)['quantity'] + $quantity;
		}

		$this->update($item, $quantity);
	}

	public function update(Item $item, $quantity){
		if(!$this->item->find($item->id)->hasStock($quantity)){
			return 'Quantity exceeded'; //throw new QuantityExceededException;
		}

		if($quantity == 0){
			$this->remove($item);
			return;
		}

		$this->storage->set($item->id, [
			'product_id' => (int) $item->id,
			'quantity' => (int) $quantity,
			]);
	}

	public function remove(Item $item){
		return $this->storage->remove($item->id);
	}

	public function has(Item $item){
		return $this->storage->exists($item->id);
	}

	public function get(Item $item){
		return $this->storage->get($item->id);
	}

	public function clear(){
		return $this->storage->clear();
	}

	public function all(){
		
		$ids = [];
		$items = [];
		$allItems = [];

		foreach ($this->storage->all() as $item) {
			$ids[] = $item['product_id'];
		}

		$items = $this->item->find($ids);

		foreach ($items as $item) {
			$item->quantity = Session::get('default.'. $item->id . '.quantity');
			$allItems[] = $item;
		}

		return $allItems;

	}		

	public function items(){
		return count($this->storage);
	}

	public function subTotal(){
		$total = 0;

		foreach($this->all() as $item){
			if($item->outOfStock()){

			}
			$total = $total + $item->price * $item->quantity;
		}
		return $total;
	}
}