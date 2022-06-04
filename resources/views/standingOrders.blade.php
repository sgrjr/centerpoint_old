@extends('layouts.app')

@section('content')

<h2>Standing Orders ({{ $standingOrdersPaginator->count }})</h2>

<ul>
	@foreach($standingOrders AS $so)
		<li>
			<table class="borders">
				<tr>
				@foreach($so->toArray() AS $key=>$value)
					<th>{{$key}}</th>
				@endforeach
				</tr>
				<tr>
				@foreach($so->toArray() AS $key=>$value)
						<td>{{$value}}</td>
				@endforeach
				</tr>
		</table>
		</li>
	@endforeach
</ul>

<hr />

<h3><a href={{url("/dashboard")}}><-- Dashboard</a></h3>

@endsection