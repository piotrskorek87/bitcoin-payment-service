@extends('main')

@section('title', '| Cart')

@section('content')

	<div class="row">
		<div class="col-md-8">
			
		@if($basket->items())
			<div class="well">
				<table class="table">
					<thead>
						<tr>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>

						@foreach($basket->all() as $item)
							<tr>
								<td><a href="{{ route('item.show', ['name' => $user->name, 'id' => $item->id]) }}">{{ $item->name }}</a></td>
								<td>$ {{ $item->price }}</td>
								<td>
									<form action="{{ route('cart.update', ['name' => $user->name, 'id' => $item->id]) }}" method="post" class="form-inline">
										<select name="quantity" class="form-control input-sm">
											@for($i = 1; $i <= $item->stock; $i++)
												<option value="{{ $i }}" @if($i == $item->quantity) selected="selected"@endif>{{ $i }}</option>
											@endfor
											<option value="0">None</option>
										</select>
										<input type="submit" class="btn btn-default btn-sm" value="Update">
										<input type="hidden" name="_token" value="{{ Session::token() }}">
									</form>
								</td>
							</tr>
						@endforeach

					</tbody>
				</table>
			</div>
		@else
			<p>You have no items in your cart. <a href="{{ url('/', ['name' => $user->name]) }}">Start shopping</a></p>
		@endif	



		</div>
		<div class="col-md-4">
			@if($basket->items())
				<div class="well">
					<h4><strong>Cart summary</strong></h4>
					<hr>
					<table class="table">
						<tr>
							<td>Sub total</td>
							<td>${{ $basket->subTotal() }}</td>
						</tr>
						<tr>
							<td>Shipping</td>
							<td>$5.00</td>							
						</tr>
						<tr>
							<td class="success">Total</td>
							<td class="success">${{ $basket->subTotal() + 5 }}</td>					
						</tr>
					</table>

					<a href="{{ route('order.index', ['name' => $user->name]) }}" class="btn btn-primary">Checkout</a>
				</div>
			@endif
		</div>
	</div>

@endsection
