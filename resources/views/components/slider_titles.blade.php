@if($highlightPagination->count > 0)
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
  
	@for($i = 0; $i < $highlightPagination->count; $i++)
		<li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
	@endfor

  </ol>
  <div class="carousel-inner">="carousel-inner"
  
	@for($i = 0; $i < $highlightPagination->count; $i++)
   
		@if($i<1)
			<div class="carousel-item active">
		@else
			<div class="carousel-item">
		@endif
	
		<img class="carousel-background" src={{$highlight[$i]->img}}>

		<div class="content">
		  <div class="column" >
				  <div class="carousel-captionXX">
				  {{-- START INVENTORY CARD --}}
          <div class="card">
              <a href={{url("/isbn/".$highlight[$i]->isbn)}} class="card-link">
                <img class="card-img-top" src={{$highlight[$i]->img}} alt="Card image cap">
              </a>
              <ul class="list-group list-group-flush">
              
              @foreach($highlight[$i]->toArray() AS $key=>$header)
                <li class="list-group-item"><strong>{{$key}}</strong> : {{$header}}</li>
              @endforeach
          
              </ul>
              <div class="card-body"></div>
            </div>

      {{-- END INVENTORY CARD --}}

				  </div>
		  </div>
		  
		  <div class="column">
			<img class="" src={{$highlight[$i]->img}}>
		  </div>
		</div>

    </div>
	@endfor
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
@endif