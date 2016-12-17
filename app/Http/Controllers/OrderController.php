<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Item;
use App\Basket\Basket;
use App\Http\Requests\OrderCreateRequest;
use App\Order;
use App\Customer;
use App\Address;
use App\User;

class OrderController extends Controller
{
	protected $basket;

    public function __construct(Basket $basket)
    {
    	$this->basket = $basket;
    }

    public function index($name)
    {
        $user = User::where('name', $name)->first();
        if(!$user){
            return redirect('/');
        }

    	if(!$this->basket->subTotal()){
    	return redirect(route('cart.index'));
    	}
        return view('order.index')->with('basket', $this->basket)->with('user', $user);
    }

    public function create($name, OrderCreateRequest $request, Customer $customer, Address $address, User $user)
    {
        if(!$this->basket->subTotal()){
            return redirect(route('cart.index'));
        }   

        $hash = substr(bin2hex(random_bytes(32)), 0, 15); 

        $customer = $customer::firstOrCreate([
            'email' => $request->email,
            'name'  => $request->name,

        ]);

        $address = $address::firstOrCreate([
            'address1' => $request->address1,
            'address2'  => $request->address2,
            'city' => $request->city,
            'postal_code'  => $request->postal_code,

        ]);

        $user = $user->where('name', $name)->first();
        if(!$user){
            return redirect('/');
        }

        foreach($this->basket->all() as $item){
            if($item->user_id != $user->id){
                $this->basket->clear();
                return redirect('/');
            }
        }

        require_once('../bitcoinpayment/block_io.php');
        $apiKey = $user->block_io_account->api_key;
        $version = 2;
        $pin =  $user->block_io_account->pin;
        $block_io = new \BlockIo($apiKey, $pin, $version);

        $newAddressInfo  = $block_io->get_new_address();
        $bitcoin_address =  $newAddressInfo->data->address;

        $order = $customer->orders()->create([
            'user_id' => $user->id,
            'hash' => $hash,
            'bitcoin_address'  => $bitcoin_address,
            'total' => $this->basket->subtotal() + 5,
            'totalBTC' => number_format((float)($this->basket->subtotal() + 5) / json_decode(file_get_contents('https://btc-e.com/api/2/btc_usd/ticker'), true)['ticker']['last'], 4, '.', ''),
            'checked' => '0',
            'address_id' => $address->id,
        ]);

        $order->products()->saveMany(
            $this->basket->all(),
            $this->getQuantities($this->basket->all())
        );

        $event = new \App\Events\OrderWasCreated($order, $this->basket);

        $event->attach([
            new \App\Handlers\EmptyBasket,
            // new \App\Handlers\NotifySeller,
        ]);

        $event->dispatch();

        return redirect(route('order.show', ['name' => $user->name, 'hash' => $hash]));
    }

    protected function getQuantities($items)
    {
        $quantities = [];

        foreach($items as $item){
            $quantities[] = ['quantity' =>$item->quantity]; 
        }

        return $quantities;
    }

    public function show($name, $hash, Order $order, User $user)
    {

        $user = $user->where('name', $name)->first();
        if(!$user){
            return redirect('/');
        }        

    	$order = $order->with(['address', 'products'])->where('hash', $hash)->first();

    	if(!$order){
    		return redirect(route('cart.index'));
    	}

        $bitcoin_checkout_btn ='';

        $bitcoin_checkout_btn .= '<form action="http://localhost/store/bitcoinpayment/payment_parser.php" method="post">
                                  <input type="hidden" name="amount" value="'. $order->totalBTC .'"> 
                                  <input type="hidden" name="transaction" value="'. $order->hash .'"> 
                                  <input type="hidden" name="BTC_address" value="'. $order->bitcoin_address .'">
                                  <input type="image" src="http://localhost/store/public/images/bitcoin-button.png" name="submit"  alt="pay with bitcoin">
                                  </form>';

    	return view('order.show')->with('order', $order)->with('user', $user)->with('bitcoin_checkout_btn', $bitcoin_checkout_btn);  	    	
    }
}
