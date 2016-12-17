<nav class="navbar navbar-default" role="navigation">
	<div class="container">
		<div class="navbar-header">
			@if(Auth::check())
				<a class="navbar-brand" href="{{ url('/admin') }}">Home</a>
			@else
				<a class="navbar-brand" href="{{ url('/') }}">Home</a>
			@endif
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">

				@if (Auth::check())
					<a href="#" style="margin-top:8px;">Welcome {{ Auth::user()->name }}</a>
			        <a href="{{ route('logout') }}" class="btn btn-default" style="margin-top:8px;">Logout</a>	
				@endif	
			</ul>
		</div>
	</div>
</nav>