@extends('main')

@section('title', '| Category')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">	
	<form class="form-vertical" role="form" method="POST" action="{{route('item.category', ['name' => $user->name])}}">
		<div class="form-group {{$errors->has('category') ? ' has-error' : ''}}">
			<select name="category" class="form-control">
				<option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
				@foreach($categories as $category)
					@if($mainCategory->id !== $category->id)
					<option value="{{ $category->id }}|||{{ $category->user_id }}">{{ $category->name }}</option>
					@endif
				@endforeach	
			</select>
		</div>
		<br>
		<div class="form-group">
			<button type="submit" class="btn btn-default btn-primary">Show</button>
		</div>
		<input type="hidden" name="_token" value="{{Session::token()}}">
	</form>
</div>
</div>
	<div class="row">
		<h2>{{ $mainCategory->name }}:</h2>
		@foreach($items as $item)
			<div class="col-md-4 col-sm-6">
				<div class="thumbnail">
					<a href="#"><img src="../../uploads/{{ $item->thumbnail()->filename }}" alt="#"></a>
					<div class="caption">
						<h4><a href="{{ route('item.show', ['name' => $user->name, 'id' => $item->id]) }}">{{ $item->name }}</a>
						<span style="float:right;">$ {{ $item->price }}</span></h4>
							@if(Auth::check())
								<a href="{{ route('item.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-default">Edit</a>
								<a href="{{ route('item.delete', ['id' => $item->id]) }}" class="btn btn-primary btn-danger">Delete</a>
							@else
								<a href="{{ route('cart.add', ['name' => $user->name, 'id' => $item->id, 'quantity' => 1]) }}" class="btn btn-primary ">Add to cart</a>
							@endif
							
					</div>
				</div>
			</div>
		@endforeach		
	</div>
	
@endsection