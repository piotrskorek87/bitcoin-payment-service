@extends('adminMain')

@section('title', '| Register')

@section('content')
	
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form action="{{ route('register') }}" method="POST">
				<label for="name">Name:</label>
				<input type="text" id="name" class="form-control" name="name" maxlength="255" required="true">
				<label for="email">Email:</label>
				<input type="text" id="email" class="form-control" name="email" maxlength="255" required="true">
				<label for="password">Password:</label>
				<input type="password" id="password" class="form-control" name="password" minlength="5" maxlength="255" required="true">
				<label for="password_confirmation">Confirn Password:</label>
				<input type="password" id="password_confirmation" class="form-control" name="password_confirmation" minlength="5" maxlength="255" required="true">
				<input type="hidden" name="_token" value="{{ Session::token() }}">
				<input type="submit" class="btn btn-success btn-lg btn-block" style="margin-top:25px;" value="submit">
			</form>
		</div>
	</div>

@endsection