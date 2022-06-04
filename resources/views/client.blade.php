@extends('layouts.app')

@section('head')

  <?php
  	$file = public_path() . '/compiled/asset-manifest.json';
  	$data = new \stdclass;
  	$data->entrypoints = [];
  	
    if(file_exists($file)) {$data = json_decode(file_get_contents($file));}
  ?>

  @foreach($data->entrypoints AS $css)
    @if(strpos($css, ".css") > -1)
    <link href={{"/compiled/" . $css}} rel="stylesheet">
    @endif
  @endforeach
    <!--
    <link href="/static/css/2.14bb1e62.chunk.css" rel="stylesheet">
    <link href="/static/css/2.14bb1e62.chunk.css.map" rel="stylesheet">
    <link href="/static/css/main.8b464620.chunk.css" rel="stylesheet">
    <link href="/static/css/main.8b464620.chunk.css.map" rel="stylesheet">
  -->
@endsection

@section('content')
      <noscript>You need to enable JavaScript to run this app.</noscript>

      <div id="root"></div>

      <script>
      window.INITIAL_STATE={!! $initial_state !!}
  	</script>

      
  @foreach($data->entrypoints AS $css)
    @if(strpos($css, ".js") > -1 )
    <script src={{"/compiled/" . $css}}></script>
    @endif
  @endforeach

<!--
      <script src="http://localhost:3000/static/js/bundle.js"></script>
      <script src="http://localhost:3000/static/js/0.chunk.js"></script>
      <script src="http://localhost:3000/static/js/1.chunk.js"></script>
      <script src="http://localhost:3000/static/js/main.chunk.js"></script>
-->
@endsection