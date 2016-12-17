<?php 

        echo '<br><br><br>Order id:';
        echo '<br> #'. $order->id;
        echo '<br><br><br>Adress:';
        echo '<br>'. $order->address->address1;
        echo '<br>'. $order->address->address2;
        echo '<br>'. $order->address->city;
        echo '<br>'. $order->address->postal_code;

        echo '<br>';
        echo '<br>';

        foreach($order->products as $item){
            echo '<br><a href="'. $item->id .'">'. $item->name .'</a>  (x  '. $item->pivot->quantity. ') <br>';
            
?>  
