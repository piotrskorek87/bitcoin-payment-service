<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;
use App\Authorization;
use App\User;
use Carbon\Carbon;
use Input;

class CheckAuthorization
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $name = $request->path();
        $name = explode('/', $request->path())[0];
        if(in_array($name, ['auth', 'admin', 'category', 'credentials', 'item', 'payment'])){
            $name = '';
        }
        $user = User::where('name', $name)->first();
        if(!$user){
            return $next($request);
        }
        $authorization = Authorization::where('user_id', $user->id)->first();
        if(!$authorization){
            $authorization = Authorization::create([
                                'user_id' => $user->id,
                                'payed' => 1,
                                'next_check' => Carbon::parse('+ 1 month')->toDateString(),
                             ]);
        }
        if($authorization->payed == 1){
            if(Carbon::today()->getTimestamp() >=  Carbon::parse($authorization->next_check)->getTimestamp()){
                $authorization->payed = 0;
                $authorization->update();
            }
        }

        if($authorization->payed == 0){
            $orders = Order::where('user_id', $user->id)->where('checked', '1')->whereDate('created_at', '>=', Carbon::parse('- 1 month')->toDateString())->whereDate('created_at', '<=', Carbon::parse('- 1 day')->toDateString())->get();
            if($orders){
                $amount = 0;
                foreach($orders as $order){
                    $amount = $amount + $order->comission;
                }

                require_once('../bitcoinpayment/block_io.php');
                $apiKey = $user->block_io_account->api_key;
                $version = 2;
                $pin =  $user->block_io_account->pin;
                $block_io = new \BlockIo($apiKey, $pin, $version);

                // if(){


                // // $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' => $user->block_io_account->primary_address, 'to_addresses' => '32RPe6Kpd7KuQozEyouQw8ZiARKP1KwN7J')); 


                $authorization->payed = 1;
                $authorization->next_check = Carbon::parse('+ 1 month')->toDateString();
                $authorization->update();


                // } else{
                    dd('You have to have balance of ' .$amount. ' BTC at your wallet');                
                // }                
                }else{
                    return $next($request);
                }


        }


        return $next($request);
    }

}



