@extends('main')

@section('title', '| Show')

@section('content')

	<div class="row">
		<div class="col-md-4">
			<img src="../../../uploads/{{ $item->thumbnail()->filename }}" alt"{{ $item->name }}" class="thumbnail img-responsive">
		</div>
		<div class="col-md-8">
			<h3>{{ $item->name }}</h3>
			<h4>$ {{ $item->price }}</h4>
			<p>{{ $item->description }}</p>
			@if(!Auth::check())
			<a href="{{ route('cart.add', ['name' => $user->name, 'id' => $item->id, 'quantity' => 1]) }}" class="btn btn-primary ">Add to cart</a>
			@endif
		</div>
	</div>


<!-- 	<div class="row">
		<div class="col-md-3">
			<div class="photoShow">
				<img src="../../uploads/{{ $item->thumbnail()->filename }}">	
			</div>
		</div>
		<div class="col-md-9">
			{{ $item->description }}
		</div>
	</div> -->
@endsection