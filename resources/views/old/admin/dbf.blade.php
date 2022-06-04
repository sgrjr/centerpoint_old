@extends('layouts.app')

@section('content')

<div style="width:550px; overflow: scroll;">

<a href="/admin/db">go to database index</a>

  <form class="form-inline" method="POST" action="{{ url('/admin/db/search') }}">
            {{ csrf_field() }}
            <input class="form-control" name="dbf" id="dbf" type="text" placeholder="file">
              <input class="form-control" name="search_field" id="search_field" type="text" placeholder="search_field">
              <input class="form-control" name="search_value" id="search_value" type="text" placeholder="search_value">
              <button class="submit-button" type="submit">
                   <span class="fa fa-search"></span>
                </button>
  </form>     

<h2>page {{$paginator->page}} of {{$paginator->pages}} (Total Records: {{number_format($paginator->total)}})</h2>

   <ul>
    <li>name: {{ $table->tableSafeName }} </li>
    <li>exists: {{ $table->exists? "true":"false" }} </li>

    @if($table->exists && $table->getConnectionName() === "dbf")
    <li>mysql/source match: {{ $table->tablesMatch()? "true":"false" }} </li>
    @endif

    <br />
    <table class="table">
    
   <tr>
    @foreach ($table->getFillable() as $col) 
      <th scope="col">{{$col}}</th>
    @endforeach
   </tr>
    
    @foreach ($records AS $rec) 
      <tr>
      @foreach ($rec->getFillable() as $prop )

        <td>{{$rec->present()->$prop}}

          @if($prop === "ISBN")
            <a href={{"/isbn/" . $rec->$prop}}>VIEW</a>
          @elseif ($prop === "TRANSNO")
            <a href={{"/admin/order/" . $rec->$prop}}>VIEW</a>
          @elseif($prop === $table->getKeyName())
            <a href={{"/admin/". $table->getTable() ."/". $rec->present()->$prop}}>VIEW</a>
          @endif
        </td>
      @endforeach
      </tr>
    @endforeach
  </table>

</div>

@for($x = 1; $x <= $paginator->pages; $x++)
  <a href={{"?page=" . $x}}>{{$x}}</a>
@endfor

@endsection
