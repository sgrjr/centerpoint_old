@extends('layouts.app')

@section('content')

<h1>Review Order Below</h1>

<a href="/cart" class="btn btn-info btn-sm" type="submit" ><i class="fa fa-angle-left"></i> Make Changes </a>

	<hr />

 @include('invoice')

<form action="/cart/update" method="post" onsubmit="return confirm('Are you sure you want to SUBMIT this cart?');">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="_method" value="POST">
  <input type="hidden" name="index" value={{$order->index}}>
  <input type="hidden" name="action" value="submit_cart">
	  <button class="btn btn-success  col-12" type="submit" >Submit Order <i class="fa fa-angle-right"></i></button>
</form>

 <script>
	button.onclick = function() {
    var div = document.getElementById('newpost');
    if (div.style.display !== 'none') {
        div.style.display = 'none';
    }
    else {
        div.style.display = 'block';
    }
};

</script>

@endsection