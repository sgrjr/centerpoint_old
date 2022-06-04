@extends('layouts.app')

@section('content')

<div class="container">

<a href="/admin/db">Database</a> > <a href="/admin/vendors">Vendors table</a>

  <h2>{{$vendor->ORGNAME}} ({{$vendor->present()->KEY}})</h2>

  <ul>
  <li><b>address: </b>{{$vendor->STREET}} {{$vendor->CITY}} {{$vendor->STATE}} {{$vendor->ZIP5}}</li> 
  <li><b>phone: </b>{{$vendor->VOICEPHONE}}</li>

  @foreach($vendorCreds AS $cred)
  <li><b>email: </b>{{$cred->EMAIL}}</li>
  <li><b>pass: </b>{{$cred->UPASS}}</li>
  @endforeach

</ul>

<h3>Active Standing Orders: </h3>

<ul>
  @foreach($standingOrders AS $so)
      <li style="{{'color:' . $so->color . ';'}}">
    {{$so->SOSERIES }} <b>DISCOUNT</b>: {{$so->DISC * 100}} % | {{$so->CANCELDATE}}</li>
  @endforeach

</ul>

<h3>Available Titles on Standing Orders: </h3>

<table>
  <tr>
    <th>ISBN</th>
    <th>TITLE</th>
    <th>SOPLAN</th>
    <th>AVAILABILITY</th>
    <th>LISTPRICE</th>
    <th>DISCOUNT</th>
    <th>SALEPRICE</th>
  </tr>

  @foreach($titles AS $title)

  <?php
    $so = $title->referenceStandingOrderList($standingOrders);
  ?>

  @if($so->isInList)
      <tr  style="{{'color:' . $so->color . ';'}}">
      <td><a href={{"/isbn/" . $title->isbn}}>{{$title->isbn}}</a></td>
      <td>{{$title->TITLE}}</td>
      <td>{{$title->SOPLAN}}</td>
       <td>{{$title->STATUS}}</td>
      <td>{{$title->LISTPRICE}}</td>
      <td>{{ $so->DISC * 100}}%</td>
      <td>{{ $so->SALEPRICE}}</td>
    </tr>
    @endif
  @endforeach
</table>

<h3>Orders: </h3>

<ul>
  @foreach($orders AS $order)
    <li>[{{$order->items->count()}}] TRANSNO: {{$order->TRANSNO}} | DATE: {{$order->DATE}} | SHIPPING: {{$order->SHIPPING}} | {{$order->freeship}}</li>
    <ul>
      @foreach($order->items AS $item)
      <li>[{{$item->REQUESTED}}] {{$item->TITLE}} | ISBN: {{$item->ISBN}} | Discount: {{$item->DISC}} (Plan: {{$item->SOPLAN}})</li>
      @endforeach
    </ul>
      
  @endforeach

</ul>


</div>

@endsection
