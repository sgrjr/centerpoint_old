@extends('layouts.app')

@section('content')

 <div class="container">

<hr />

@include('admin.displaytables')

<hr />

<h2>Command History</h2>
<ul>
	@foreach($commandHistory AS $c)
	<li>{{$c["command"]}} : {{$c["options"]}}</li>
	@endforeach
</ul>
<hr />
<h2>Batch Actions</h2>

<form action="/admin/db" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="_method" value="POST">
  <input type="hidden" id="command" name="command" value="DROP_TABLE"/>
  <input type="hidden" id="options" name="options" value={{"{\"name\":\"ALL\"}"}} />
  <input type="submit" value="DROP ALL DBF SOURCED TABLES">
</form> 

<form action="/admin/db" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="_method" value="POST">
  <input type="hidden" id="command" name="command" value="CREATE_TABLE"/>
  <input type="hidden" id="options" name="options" value={{"{\"name\":\"ALL\"}"}} />
  <input type="submit" value="CREATE ALL DBF SOURCED TABLES">
</form> 

<form action="/admin/db" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="_method" value="POST">
  <input type="hidden" id="command" name="command" value="SEED_TABLE"/>
  <input type="hidden" id="options" name="options" value={{"{\"name\":\"ALL\"}"}} />
  <input type="submit" value="SEED ALL DBF SOURCED TABLES">
</form> 

<form action="/admin/db" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="_method" value="POST">
  <input type="hidden" id="command" name="command" value="REBUILD_ALL_DBF_TABLES"/>
  <input type="hidden" id="options" name="options" value={{"{\"name\":\"ALL\"}"}} />
  <input type="submit" value="REBUILD ALL DBF SOURCED TABLES">
</form> 

</div>
@endsection
