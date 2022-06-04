@extends('dashboard')

@section('dashboard-content')

{!! $resource->renderLinks() !!}

<div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
				@foreach($resource->headers AS $header)
                  <th>{{$header}}</th>
				@endforeach
                </tr>
              </thead>
              <tbody>
			  
				@foreach($resource->records AS $item)

                  <tr>
					@foreach($resource->headers AS $header)
	
						@if(strtolower($header) === "index" )
							<td><a href={{url($resource->model->route('admin') . "/" . $item[$header])}}>{{$item[$header]}}</a></td>
						@elseif($type === "order" && strtolower($header) === "TRANSNO")
								<td><a href={{url($resource->model->route('admin') . "/" . $item[$header])}}>{{$item[$header]}}</a></td>
						@else
							<td>{{$item[$header]}}</td>
						@endif
						
					@endforeach
				  </tr>
				@endforeach
				
              </tbody>
            </table>
          </div>

@endsection