@extends('main')

@section('title', '| Block.io credentials')

@section('content')

	<form action="{{ route('credentials.store') }}" method="post">
		<div class="col-md-6">
			<h3>Account details</h3>
			<hr>
			<div class="form-group {{$errors->has('api_key') ? ' has-error' : ''}}">
				<label for="api_key">API key</label>
				<input type="text" name="api_key" id="api_key" class="form-control" value="{{Request::old('api_key') ?  : ''}}">
				@if($errors->has('api_key'))
					<span class="help-block">{{$errors->first('api_key')}}</span>
				@endif
			</div>
			<div class="form-group {{$errors->has('pin') ? ' has-error' : ''}}">
				<label for="pin">PIN</label>
				<input type="text" name="pin" id="pin" class="form-control" value="{{Request::old('pin') ?  : ''}}">
				@if($errors->has('pin'))
					<span class="help-block">{{$errors->first('pin')}}</span>
				@endif
			</div>
			<div class="form-group {{$errors->has('primary_address') ? ' has-error' : ''}}">
				<label for="primary_address">Primary bitcoin address</label>
				<input type="text" name="primary_address" id="primary_address" class="form-control" value="{{Request::old('primary_address') ?  : ''}}">
				@if($errors->has('primary_address'))
					<span class="help-block">{{$errors->first('primary_address')}}</span>
				@endif
			</div>
			<input type="hidden" name="_token" value="{{ Session::token() }}">
			<input type="submit" class="btn btn-primary" value="Change">
		</div>
	</form>	
@endsection

@if(Auth::check())@endif