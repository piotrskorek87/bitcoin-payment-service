@extends('adminMain')

@section('content')
	
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form action="{{ route('login') }}" method="POST">
				<label for="email">Email:</label>
				<input type="text" id="email" class="form-control" name="email" maxlength="255" required="true">
				<label for="password">Password:</label>
				<input type="password" id="password" class="form-control" name="password" minlength="5" maxlength="255" required="true">
				<input type="hidden" name="_token" value="{{ Session::token() }}">
				<input type="submit" class="btn btn-success btn-lg btn-block" style="margin-top:25px;" value="submit">
			</form>	
		</div>
	</div>

@endsection