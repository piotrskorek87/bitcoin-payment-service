@extends('main')

@section('title', '| Create')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form class="form-vertical" role="form" method="POST" action="{{route('category.store')}}">
				<div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
					<label for="name" class="control-label">Category name</label>
					<input type="text" name="name" class="form-control" id="name" value="{{Request::old('name') ?  : ''}}">
					@if($errors->has('name'))
						<span class="help-block">{{$errors->first('name')}}</span>
					@endif
				</div>		
				<div class="form-group">
					<button type="submit" class="btn btn-success">Add</button>
				</div>
				<input type="hidden" name="_token" value="{{Session::token()}}">
			</form>
		</div>		
	</div>		

@endsection