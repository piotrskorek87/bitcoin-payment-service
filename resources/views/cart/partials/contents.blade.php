<table class="table">
	@foreach($basket->all() as $item)
		<tr>
			<td>{{ $item->name }}</td>
			<td>{{ $item->quantity }}</td>
		</tr>
	@endforeach
</table>