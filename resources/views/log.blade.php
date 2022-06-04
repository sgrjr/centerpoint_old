<ul>

@foreach($items AS $item)
	<li>
		<ul>
			<li>ID: [{{$item->id}}] CREATED AT: [{{$item->created_at}}] IP: [{{$item->ip}}] </li>
			<li>URL: [{{$item->url}}]</li>
			<li>REQUEST:[{{$item->request}}]</li>
			<li>{{ $item->response }}</li>
		</ul>
	<li>
@endforeach
</ul>