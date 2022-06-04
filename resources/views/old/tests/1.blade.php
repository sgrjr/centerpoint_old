<style>
	.vcontain {
		display:flex;
	}
	.vtests {
		border: solid 1px lightblue;
		
	}
</style>

<ul>
	<li>VENDOR INDEXES USED: {{$data->indexes}}</li>
</ul>

<div class="vcontain">
@foreach($data->vendors->records AS $v)

<div class="vtests">
<h2 style="color:red;" >Organization: {{$v->ORGNAME}} </h2>

<ul>
	<li >KEY {{$v->KEY}}</li>
</ul>

<h3>Cached Orders</h3>

<ul>
	@foreach($v->orders AS $order)
		<li> CACHE ORDER: {{json_encode($order) }}

			<ul>DETAILS: 
				@foreach($order->items AS $item)
					<li>{{json_encode($item)}}</li>
				@endforeach
			</ul>

		</li>
	@endforeach
</ul>

<h3>Standing Orders</h3>

<ul>
	@foreach($v->getStandingOrdersConnection()->records AS $order)
		<li>{{$order->QUANTITY }} - {{$order->SOSERIES}}</li>
	@endforeach

</ul>

<h3>Web Orders (OPEN)</h3>

<ul>
	@foreach($v->getWebOrdersConnection()->records AS $order)
		<li>{{json_encode($order) }}</li>
	@endforeach

</ul>


<h3>Web Orders (PROCESSING)</h3>

<ul>
	@foreach($v->getProcessingWebOrdersConnection()->records AS $order)
		<li>{{json_encode($order) }}</li>
	@endforeach
</ul>

<h3>Credentials</h3>

@foreach($v->getCredentialsConnection()->records AS $cr)
<p>{{$cr->EMAIL}} {{$cr->UPASS}}</p>
@endforeach

</div>

@endforeach
</div>