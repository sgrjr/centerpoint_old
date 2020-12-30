@foreach($links AS $link)
	<a href={{$link["url"]}}>{{$link["text"]}}</a><hr/>
@endforeach
