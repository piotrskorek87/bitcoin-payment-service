@extends('adminMain')

@section('title', '| Admin')

@section('content')

	<div class="row">
		<div class="row">
			<div class="col-md-6">
				<h3>Manage your store</h3>
				<a href="{{ route('item.create') }}" class="btn btn-primary btn-default">Add new item</a>
				<br>
				<br>
				<a href="{{ route('category.create') }}" class="btn btn-primary btn-default">Add new category</a>
				<br>
				<br>
				<a href="{{ route('credentials.create') }}" class="btn btn-primary btn-default">Add bitcoin payment credentials</a>
				<br>
				<br>
				<a href="{{ route('item.index', ['name' => Auth::User()->name]) }}" class="btn btn-primary btn-default">See all products</a>
				<br>
				<br>
			</div>
			<div class="col-md-6">
				<h3>Find bitcoin transaction</h3>
				<form action="{{ route('payment.show') }}" method="POST" class="form-inline">
					<input type="text" name="transaction" class="form-control">
					<input type="hidden" name="_token" value="{{ Session::token() }}">
					<input type="submit" value="Find" class="btn btn-primary">
				</form>					
			</div>
		</div>
	</div>
@endsection

@if(Auth::check())@endif