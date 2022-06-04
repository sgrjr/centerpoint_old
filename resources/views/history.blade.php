@extends('layouts.app')

@section('content')

<h1>Order History</h1>

<ul>
	@foreach($history AS $order)
		<li>
		<b>Date:</b> {{$order->DATE}} 
		<b>Transaction #:</b> {{$order->TRANSNO}} 
		<b>Source:</b>   {{$order->OSOURCE}}
		<b>PO #:</b>   {{$order->PO_NUMBER}}
		<a href={{ $order->detailsUrl}}>View</a>
		</li>
	@endforeach
</ul>

<h3><a href={{url("/dashboard")}}><-- Dashboard</a></h3>

@endsection