@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="product-filter">
        @if($search)
        <h2>

            Results for "{{$search}}"

            @if(isset($searchCategory))
             in "{{$searchCategory}}"
            @endif

            (page {{$paginator->page}} of {{$paginator->pages}} | {{$paginator->total}} Found)
        </h2>

         @endif
    </nav>
    @include("components.products_list",["titles"=>$titles, "mainClass"=>"", "listtitle"=>"" ])

            <p>
            @for($i=1; $i<=$paginator->pages; $i++)
                <a href={{"?page=" . $i}}>{{$i}}</a> |
            @endfor
        </p>
</div>

@endsection
