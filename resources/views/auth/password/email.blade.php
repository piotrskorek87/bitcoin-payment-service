@extends('main')

@section('title', '| Forgot my Password')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>

				<div class="panel-body">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

					<form action="{{ route('password.email') }}" method="POST" class="form-control">
						<label for="email">Email:</label>
						<input type="text" id="email" class="form-control" name="email" maxlength="255" required="true">
						<input type="hidden" name="_token" value="{{ Session::token() }}">
						<input type="submit" class="btn btn-success btn-lg btn-block" style="margin-top:25px;" value="submit">
					</form>	
				</div>
			</div>
		</div>
	</div>

@endsection