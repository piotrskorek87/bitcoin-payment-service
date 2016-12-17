@extends('main')

@section('title', '| Welcome')

@section('content')


	<div class="row">
		<div class="col-md-4">
			<h2>Welcome to CryptoStores!</h2>
			<h3>Have fun ;)</h3>
			<br>
			<br>
			<br>
			<a href="{{route('register')}}" class="btn btn-success btn-lg btn-block">Sign up with us</a>
		</div>		
	</div>

	

@endsection

@if(Auth::check())@endif