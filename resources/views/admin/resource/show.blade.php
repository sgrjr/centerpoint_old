@extends('dashboard')

@section('dashboard-content')

    @if($resource->type === "vendor")
        
	<div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
				@foreach($resource->headers AS $header)
                  <th>{{$header}}</th>
				@endforeach
                </tr>
              </thead>
              <tbody>
			  

                  <tr>
					@foreach($resource->headers AS $header)
						@if($header === "key")
							<td><a href={{url("/" .$resource->path . "/" . $resource->item[$header])}}>{{$resource->item[$header]}}</a></td>
						@else
							<td>{{$resource->item[$header]}}</td>
						@endif
						
					@endforeach
				  </tr>
				
              </tbody>
            </table>
          </div>
		  
		  @if($resource->item->getDiscount('wholesale') !== false)
		  <h2>Wholesale Discount</h2>
		  {{$resource->item->getDiscount('wholesale')}}
		  @endif
		  
		  <h2>Credentials</h2>

		  @foreach($resource->item->getCredentialsConnection()->records AS $cred)
		  <p>
		  	 {{$cred->uname}} : {{$cred->email}} : {{$cred->upass}}
		  </p>
		  @endforeach

		  <h2>Standing Orders</h2>
		  
		  <ul>
			@foreach($resource->item->getStandingOrdersConnection()->records AS $so)
				<li>{{$so->SOSERIES}}</li>
			@endforeach
		  </ul>
		  
		  <h2>Recent Orders</h2>
		  
		  <ul>
			@foreach($resource->item->orders AS $order)
				<li>transaction no: {{$order->TRANSNO}} date: {{$order->DATE}} PO#: {{$order->PO_NUMBER}}
				
				  <ul>
					@foreach($order->items AS $detail)

						<li><a href={{url("/admin/inventory/" . $detail->ISBN)}}> {{$detail->TITLE}}</a> {{$detail->ISBN}}</li>
					@endforeach
				  </ul>
				
				</li>
			@endforeach
		  </ul>
   @endif
   
   @if($resource->type === "inventory")
        
		<div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
				@foreach($resource->headers AS $header)
                  <th>{{$header}}</th>
				@endforeach
                </tr>
              </thead>
              <tbody>
			  

                  <tr>
					@foreach($resource->headers AS $header)
						@if($header === "isbn")
							<td><a href={{url("/" .$resource->path . "/" . $resource->item[$header])}}>{{$resource->item[$header]}}</a></td>
						@else
							<td>{{$resource->item[$header]}}</td>
						@endif
						
					@endforeach
				  </tr>
				
              </tbody>
            </table>
          </div>

   @endif
   
   @if($resource->type === "order")

		<h1>Vendor: <a href={{"/admin/vendors/" . $resource->item->key}}> {{$resource->item->key}}</a> </h1>
		transaction no: {{$resource->item->transno}}
		date: {{$resource->item->date}}
			
			<h2>Titles:</h2>
			@foreach($resource->item->items AS $detail)
				<li>{{$detail->TITLE}} [<a href={{"/admin/inventory/" . $detail->ISBN}}>{{$detail->ISBN}}</a>] by {{$detail->AUTHOR}}</li>
			@endforeach

   @endif
		
@endsection