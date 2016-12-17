<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Item;
use App\User;
use App\Basket\Basket;

class CartController extends Controller
{
	protected $basket;
    protected $item;

    public function __construct(Basket $basket, Item $item)
    {
    	$this->basket = $basket;
        $this->item = $item;
    }

    public function index($name)
    {
        $user = User::where('name', $name)->first();
        if(!$user){
            return redirect('/');
        }
    	$items = Item::all();  // correct that 
        return view('cart.index')->with('items', $items)->with('basket', $this->basket)->with('user', $user);
    }

    public function add($name, $id, $quantity)
    {
        $user = User::where('name', $name)->first();
        if(!$user){
            return redirect('/');
        }

    	$item = $this->item->where('id', $id)->where('user_id', $user->id)->first();
        if(!$item){
            return redirect('/');
        }        

        try{
        	$this->basket->add($item, $quantity);
        } catch(QuantityExceededException $e){
        	//
        }

        return view('cart.index')->with('basket', $this->basket)->with('user', $user);
    }

    public function update($name, $id, Request $request)
    {
        $item = $this->item->where('id', $id)->first();
        if(!$item){
            return redirect(route('home'));
        }

        try{
            $this->basket->update($item, $request->quantity);
        } catch(QuantityExceededException $e){
            //
        }

        return redirect(route('cart.index', ['name' => $name]));
    }
}
