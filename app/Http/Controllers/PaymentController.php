<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Item;
use App\Order;
use App\User;
use Auth;

class PaymentController extends Controller
{
    public function show(Order $order, User $user, PaymentRequest $request)
    {

        $order = $order->where('bitcoin_address', $request->transaction)->where('user_id', Auth::User()->id)->first();

        if(!$order){
            return redirect(route('admin'))->with('error', 'Can not find this order');
        }

        $balance = file_get_contents('https://blockchain.info/de/q/addressbalance/'. $order->bitcoin_address);
        if($balance != 0){
            if($order->checked !== '1'){            
                $comission = number_format((float) $balance * 0.05, 5, '.', '');
                $order->BTC_received = $balance;
                $order->comission = $comission;
                $order->checked = '1';
                $order->update();  

                // if($balance != $order->totalBTC){
                //     $payment_difference = $order->totalBTC - $balance;
                //     $order->payment_difference = $payment_difference;
                //     $order->update();
                // }              
            }
            if($balance > $order->BTC_received){
                $comission = number_format((float) $balance * 0.05, 5, '.', '');
                $order->BTC_received = $balance;
                $order->comission = $comission;
                // $order->updated_at = today();
                $order->update();  
            }                
        }
        echo 'Amount payed for the commision: '. $order->comission . ' BTC<br>';

        echo '<a href="../admin" style="text-decoration: none;">Go back</a>';

        // echo "<br>!!!!!!!". file_get_contents('https://blockchain.info/de/q/addressbalance/'. $order->bitcoin_address) ."!!!!!!!";
        echo '<br><br><br><strong>Transaction id:</strong>';
        echo '<br>'. $order->bitcoin_address;
        echo '<br><br><br><strong>Transaction made on:</strong>';
        echo '<br>'. $order->created_at;
        echo '<br><br><br><strong>Customer:</strong></strong>';
        echo '<br>'. $order->customer->name;       
        echo '<br><br><strong>Adress:</strong>';
        echo '<br>'. $order->address->address1;
        echo '<br>'. $order->address->address2;
        echo '<br>'. $order->address->city;
        echo '<br>'. $order->address->postal_code;  
        echo '<br><br><strong>Items:</strong>';
        foreach($order->products as $item){
            echo '<br><a href="../item/show/'. $item->id .'" style="text-decoration: none;">'. $item->name .'</a>  (x  '. $item->pivot->uantity. ')';
        }
        echo '<br><br><br><strong>Total amount:</strong>';
        echo '<br>'. $order->total .' USD'; 
        echo '<br><br><a href="'. route('payment.markaspaid', ['transactionId' => $order->hash]) .'" style="text-decoration: none;">!! Mark as paid !!</a>'; 
        echo'<br>----------------------------------------------------------------';   

        // if(file_get_contents('https://blockchain.info/de/q/addressbalance/'. $order->bitcoin_address) == $order->totalBTC){
        //     echo 'Transaction went fine :)';
        // }               
    }
}
