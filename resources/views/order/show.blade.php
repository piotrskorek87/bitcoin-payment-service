@extends('main')

@section('title', '| Order')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>Order # {{ $order->id }}</h3>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<h4>Bitcoin address</h4>
					<i>{{ $order->bitcoin_address }}</i>
					<h4>Shipping to</h4>
					<br> {{ $order->address->address1 }}
					<br> {{ $order->address->address2 }}
					<br> {{ $order->address->city }}
					<br> {{ $order->address->postal_code }}
				</div>
				<div class="col-md-6">
					<h4>Items</h4>
					@foreach($order->products as $item)
						<a href="{{ route('item.show', ['name' => $user->name, 'id' => $item->id]) }}">{{ $item->name }}</a>  (x  {{ $item->pivot->quantity}}) <br>
					@endforeach

					{!! $bitcoin_checkout_btn !!}
				</div>
			</div>
			<hr>
			<p>Shipping: $ 5.00</p>
			<strong>Order total: $  {{ $order->total }}</strong>
		</div>	
	</div>

@endsection