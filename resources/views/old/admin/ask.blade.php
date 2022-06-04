@extends('layouts.app')

@section('content')

<div style="width:100%">

<a href="/admin/db">go to database index</a>    

<h2>Model</h2>

    <li>name: {{ $results->model->tableSafeName }} </li>
    <li>exists: {{ $results->model->exists? "true":"false" }} </li>

    @if($results->model->exists && $results->model->getConnectionName() === "dbf")
    <li>mysql/source match: {{ $results->model->tablesMatch()? "true":"false" }} </li>
    @endif

<h2>Paginator</h2>

<p>{{ json_encode($results->paginator) }}</p>

<h2>Records</h2>

<table class="table">
    
   <tr>
    @foreach ($results->headers as $col) 
      <th scope="col">{{$col}}</th>
    @endforeach
   </tr>
    
    @if(!$hide)
        @foreach ($results->records AS $rec) 
          <tr>
          @foreach ($results->headers as $prop )
            <td>{{$rec->present()->$prop}}
              @if($prop === "ISBN")
                <a href={{"/isbn/" . $rec->$prop}}>VIEW</a>
              @elseif ($prop === "TRANSNO")
                <a href={{"/admin/order/" . $rec->$prop}}>VIEW</a>
              @elseif($prop === $results->model->getKeyName())
                <a href={{"/admin/". $results->model->getTable() ."/". $rec->present()->$prop}}>VIEW</a>
              @endif
            </td>
          @endforeach
          </tr>
        @endforeach
    @endif

  </table>

<h2>Lists</h2>

@if(!$hide)
    <p>{{ json_encode($results->lists) }}</p>
@endif

</div>

@endsection
