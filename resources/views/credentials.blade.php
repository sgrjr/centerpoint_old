@extends('layouts.app')

@section('content')

<h2>Settings and Preferences</h2>

@if(count($credentials->toArray()) > 0)

<ul>
	@foreach($credentials->toArray() AS $k=>$v)
		<li><b>{{$k}}:</b> {{$v}}</li>
	@endforeach
</ul>
@endif

<hr />

@if($vendor !== null)

	<h2>Organization: {{ $vendor->ORGNAME }} {{$vendor->TITLE? "(".$vendor->TITLE.")" : ""}}</h2>
	{{-- 
	<!--
	@if($viewer->user->organization->wdiscount !== false)
		<p>Whole Saler Discount: {{$viewer->user->organization->wdiscount}}</p>
	@endif
	-->
	--}}

	<ul>
		@foreach($vendor->toArray() AS $k=>$v)
			<li><b>{{$k}}:</b> {{$v}}</li>
		@endforeach
	</ul>

@endif

<hr />

<h3><a href={{url("/dashboard")}}><-- Dashboard</a></h3>

@endsection