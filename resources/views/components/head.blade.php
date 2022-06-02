<!-- head -->

<title>{{$page->title}}</title>

@foreach($page->meta AS $x)
		<meta name="{{$x->name}}" content="{{$x->content}}" />
@endforeach

@foreach($page->links AS $x)
		<link {{$x}} />
@endforeach