<h1 style="clear:both;">{{$listtitle}}</h1>

<div class="products-container {{$mainClass}}">
  <ul class="products-flex-container">
    
        @foreach($titles AS $title)

          <!-- Just add class "flip" for book flip affect, i.e.: class="book flip"-->
          <li class="flex-book-item">
            
            <div class="cover">
                @if(isset($title->ISBN))
                 <a href={{url("/isbn/".$title->ISBN . "?index=" . $title->index)}}>
                @endif

                    @if(isset($title->smallImage))
                    <div class="art" style={{"background-image:url(".$title->smallImage.")"}}>
                    @else
                    <div class="art" style="background-image:url('/img/no-image.png')">
                    @endif
                    <span class="effect"></span>
                </div>
                @if(isset($title->ISBN))
                </a>
                @endif
            </div>

            <div class="details">
              @if(isset($title->TITLE))
              <span class="title">{!!$title->TITLE!!}</span>
              @endif
              @if(isset($title->author))
              <span class="author">{{$title->author}}</span>
                            @endif
              @if(isset($title->listprice))
                <span class="price">$ {{$title->listprice}}</span>
              @endif
            </div>

          </li>
        
        @endforeach

  </ul>
</div>