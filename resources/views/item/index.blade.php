@extends('main')

@section('title', '| Index')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">	
			<form class="form-vertical" role="form" method="POST" action="{{route('item.category', ['name' => $user->name])}}">
				<div class="form-group {{$errors->has('category') ? ' has-error' : ''}}">
					<select name="category" class="form-control">
						@foreach($categories as $categories)
							<option value="{{ $categories->id }}|||{{ $categories->user_id }}">{{ $categories->name }}</option>
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
		<h2>All items:</h2>
		@foreach($items as $item)
			<div class="col-md-4 col-sm-6">
				<div class="thumbnail">
					<a href="#"><img src="../../uploads/{{ $item->thumbnail()->filename }}" alt="#"></a>
					<div class="caption">
						<h4><a href="{{ route('item.show', ['name' => $user->name, 'id' => $item->id]) }}">{{ $item->name }}</a></h4>
						
							<a href="{{ route('item.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-default">Edit</a>
							<a href="{{ route('item.delete', ['id' => $item->id]) }}" class="btn btn-primary btn-danger">Delete</a>
							
					</div>
				</div>
			</div>
		@endforeach	
	</div>
	
@endsection
