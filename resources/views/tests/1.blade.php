<h1> / Url Tester</h1>

<style>
	.compare {
		width:30%;
		float:left;
	}

	.compare span {
		font-style: italic;
	}
</style>

<div class="compare">
<b>cp ({{count($response->cp)}})</b>
@foreach($response->cp AS $title)
	<span>{{$title->TITLE}}, </span>
@endforeach
</div>
<div class="compare">
	<b>trade ({{count($response->trade)}})</b>
@foreach($response->trade AS $title)
	<span>{{$title->TITLE}}, </span>
@endforeach
</div>
<div class="compare">
	<b>advanced ({{count($response->advanced)}})</b>
@foreach($response->advanced AS $title)
	<span>{{$title->TITLE}}, </span>
@endforeach
</div>