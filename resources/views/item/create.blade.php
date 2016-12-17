@extends('main')

@section('title', '| Create')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form class="form-vertical" role="form" method="POST" enctype="multipart/form-data" action="{{route('item.store')}}">
				<div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
					<label for="name" class="control-label">Item name</label>
					<input type="text" name="name" class="form-control" id="name" value="{{Request::old('name') ?  : ''}}">
					@if($errors->has('name'))
						<span class="help-block">{{$errors->first('name')}}</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('description') ? ' has-error' : ''}}">
					<label for="description" class="control-label">Item description</label>
					<textarea name="description" class="form-control" id="description">{{Request::old('description') ?  : ''}}</textarea>
					@if($errors->has('description'))
						<span class="help-block">{{$errors->first('description')}}</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('category') ? ' has-error' : ''}}">
					<label for="description" class="control-label">Category</label>
					<select name="category" class="form-control">
						@foreach($categories as $category)
							<option value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach	
					</select>					
					@if($errors->has('category'))
						<span class="help-block">{{$errors->first('category')}}</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('price') ? ' has-error' : ''}}">
					<label for="price" class="control-label">Price</label>
					<input type="text" name="price" class="form-control" id="price" value="{{Request::old('price') ?  : ''}}">
					@if($errors->has('price'))
						<span class="help-block">{{$errors->first('price')}}</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('seller_email') ? ' has-error' : ''}}">
					<label for="seller_email" class="control-label">Seller email</label>
					<input type="text" name="seller_email" class="form-control" id="seller_email" value="{{Request::old('seller_email') ?  : ''}}">
					@if($errors->has('seller_email'))
						<span class="help-block">{{$errors->first('seller_email')}}</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('photo') ? ' has-error' : ''}}">
					<label for="photo" class="control-label">Add Thumbnail</label>
					<input type="file" name="photo" class="form-control" id="photo">
					@if($errors->has('photo'))
						<span class="help-block">{{$errors->first('photo')}}</span>
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