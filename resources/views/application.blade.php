@extends('layouts.app')

@section('content')

 <div class="container">
  	<form action="/admin/application" method="post">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
	  <input type="hidden" name="_method" value="POST">
	  <span>command: </span>
	  <input type="text" id="command" name="command" value="GIT_PULL"/>
	  
	  <p>options: </p>
	  <input type="text" id="options" name="options" style="width:100%; display:block"/>
	  <br><br>
	  <input type="submit" value="execute command">
	</form> 
<div style="background-color:black; color:white;">
	<ol>
@if(is_array($response) )
	@foreach ($response as $key => $val) 

	@if(is_array($val))
		@foreach($val AS $v)
			<li>{{$v}}</li>
		@endforeach
	@else
		<li>{{$key}} : {{$val}}</li>
	@endif
	
	@endforeach
@endif	
	</ol>
</div>

<h2>ENV</h2>
<form id="envform" name="envform" action="/admin/application/env" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
 
  <span>env: </span>
  <textarea name="env" form="envform" rows="25" style="width:100%;">{{$envi}}</textarea>

  <br><br>
  <input type="submit" value="Save">
</form>

<h2>ERROR</h2>
<form id="errorform" name="errorform" action="/admin/application/error" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
 
  <span>error: </span>
  <textarea name="error" form="errorform" rows="25" style="width:100%;">{{$error}}</textarea>

  <br><br>
  <input type="submit" value="Save">
</form>

</div>
@endsection


