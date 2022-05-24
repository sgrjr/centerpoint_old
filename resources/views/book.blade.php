@extends('layouts.app')

@section('content')
<div class="container" style="display:flex;flex-wrap: nowrap;justify-content:center;">
	<div style="margin:auto auto; width:200px;">
		
		@if($title !== null)

            <div class="cover">
               <div class="art" style={{"background-image:url(".$title->smallImage.")"}}>
                    <span class="effect"></span>   
               </div>
            </div>

		@if(Auth::check())
			<hr />
			<br />
			@include('order_form',["isbn"=>$title->isbn, "index"=>$title->index])
		@endif

	</div>

		<div style="margin:auto auto; width:200px;">
		
			<h1>{{$title->TITLE}}</h1>

			<p>{!!$title->SUBTITLE!!}</p>


			@if(Auth::check())
			<h2 style="color:green; font-weight: bold;">$ {{number_format($title->referenceStandingOrderList(Auth::user()->key)->SALEPRICE,2)}}</h2>
			@endif

			<p>LIST PRICE: $ {{number_format($title->listprice,2)}}</p>

			<p>{!!$title->highlight!!}</p>

			<h2>Details</h2>

					<li><i>author</i>: {{$title->author}}</li>
					<li><i>status</i>: {{$title->status}}</li>
					<li><i>ISBN</i>: {{$title->isbn}}</li>
					<li><i>publisher</i>: {{$title->publisher}}</li>
					<li><i>publish date</i>: {{$title->pubdate}}</li>
					<li><i>pages</i>: {{$title->pages}}</li>
					<li><i>format</i>: {{$title->format}}</li>
					<li><i>category</i>: {{$title->category}}</li>

					@if($title->marc === "MARC")
					<li><i>marc</i>: <a href={{"http://www.dgiinc.com/centerpoint/".$title->isbn.".mrc"}}>download</a> | <a href={{"http://www.dgiinc.com/centerpoint/".$title->isbn.".txt"}} target="_BLANK">view</a></li>
					@endif
			</ul>
		@endif
	</div>
</div>
<hr />
		@foreach($booktext AS $text)
			@if($text->body->type !== "bookcopy")
			<div class="container">	
				<p><b>{{ $text->body->subject }}</b>:  {!! $text->body->body !!}</p>
			</div>
			@endif
		@endforeach

	<div class="container">
		 @include("components.products_list",["titles"=>$authorTitles, "mainClass"=>"scroll", "listtitle"=> "Books By " . $title->AFIRST . " " . $title->ALAST . ": "])
	</div>

	<div class="container">
		 @include("components.products_list",["titles"=>$genreTitles, "mainClass"=>"scroll", "listtitle"=>  $title->CAT])
		 <a class="btn btn-primary" href={{"/search/".str_replace("+", "%20",urlencode($title->CAT) ) . "/CAT"}}>view more</a>
	</div>

	

@endsection