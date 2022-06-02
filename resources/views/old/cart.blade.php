@extends('layouts.app')

@section('content')

	<div style="clear:both; width:100%; height:50px">
		<a href="/search" class="btn btn-warning float-left btn-sm"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>

		<form action="/cart/create-new-cart" method="post" class="float-right">
		  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		  <input type="hidden" name="_method" value="POST">
			  <button class="btn btn-info btn-sm" type="submit" >Start a New Cart <i class="fa fa-angle-right"></i></button>
		</form>
	</div>

	<hr />

	@foreach($webHead->records AS $cart)
			@include('shoppingcart',["cart"=>$cart->invoiceVars()])
		<hr />
	@endforeach

@endsection
