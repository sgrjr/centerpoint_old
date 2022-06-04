@extends('layouts.app')

@section('content')

<h1>My Purchased Titles</h1>

<div  class="products">

        @foreach($titles AS $title)

          <!-- Just add class "flip" for book flip affect, i.e.: class="book flip"-->
          <div class="book">
            
            <div class="cover">

                 <a href={{url("/isbn/".$title->ISBN)}}>
                  <div class="art" style={{
                    "background-image:url(".
                    "/img/small/" . 
                    $title->ISBN . 
                    ".JPG)"
                }}>
                    <span class="effect"></span>
                </div>
                </a>
            </div>

            <div class="details">
            	<span class="title">{!!$title->TITLE!!}</span>
            	<span class="author">{{$title->AUTHOR}}</span>
                <span class="price">$ {{$title->SALEPRICE}}</span>
            </div>

          </div>
        
        @endforeach
        
</div>

<h3><a href={{url("/dashboard")}}><-- Dashboard</a></h3>

@endsection