<style>
	     
.carousel-item, .carousel {
  height:{{$slider["height"]}};
}

.carousel-item, .carousel {
  background-color:{{$slider["background_color"]}};
}

</style>


@if(count($slider["slides"]) > 0)

<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
  
	@for($i = 0; $i < count($slider["slides"]); $i++)
		<li data-target="#carouselIndicators" data-slide-to="{{$i}}"></li>
	@endfor

  </ol>

  <div class="carousel-inner text-center">

  		@for($i = 0; $i < count($slider["slides"]); $i++)
   			<?php $styleSet = isset($slider["slides"][$i]["style"]); ?>
		@if($i<1)

			@if(isset($slider["slides"][$i]["image"]))
			
			<div class="carousel-item active" style="background-image: url({{url($slider["slides"][$i]["image"] )}}); {{$styleSet? $slider["slides"][$i]["style"]: ''}}">

			@else
			<div class="carousel-item active" style="{{$styleSet? $slider["slides"][$i]["style"]: ''}}">
			@endif
		@else

			@if(isset($slider["slides"][$i]["image"]))
			
			<div class="carousel-item" style="background-image: url({{url($slider["slides"][$i]["image"] )}}); {{$styleSet? $slider["slides"][$i]["style"]: ''}}">

			@else
			<div class="carousel-item" style="{{$styleSet? $slider["slides"][$i]["style"]: ''}}">
			@endif
	
		@endif

			@if(isset($slider["slides"][$i]["link"]))
			<a href={{url($slider["slides"][$i]["link"] )}}>
			@endif
            <div 
            @if(isset($slider["slides"][$i]["caption_class"]))
           		class="{{ $slider["slides"][$i]["caption_class"] }}"
            @else 
            	class="d-flex h-100 align-items-center justify-content-center"
            @endif
            >
             @if(isset($slider["slides"][$i]["caption"]))
			 	<h1>{!! $slider["slides"][$i]["caption"] !!}</h1>
			 @endif
            </div>

            @if(isset($slider["slides"][$i]["link"]))
            </a>
            @endif
    </div>

	@endfor

  </div>
  <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

@endif