<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Center Point Large Print') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <!-- Fonts -->

    <!-- Styles -->
     <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>

    <script>
      window.INITIAL_STATE= <?php echo $initial_state ?? "{viewer:{}}" ;?>
    </script>

    <div id="app">
        
<div id="app">

  <style>
html, body {
  background: #008afc;
  width: 100%;
  overflow-x: hidden;
  overflow-y: hidden;
}

.bar {
  position: relative;
  height: 2px;
  width: 500px;
  margin: 0 auto;
  background: #fff;
  margin-top: 150px;
}

.circle {
  position: absolute;
  top: -30px;
  margin-left: -30px;
  height: 60px;
  width: 60px;
  left: 0;
  background: #fff;
  border-radius: 30%;
  -webkit-animation: move 5s infinite;
}

p {
  position: absolute;
  top: -35px;
  right: -85px;
  text-transform: uppercase;
  color: #347fc3;
  font-family: helvetica, sans-serif;
  font-weight: bold;
}

@-webkit-keyframes move {
  0% {left: 0;}
  50% {left: 100%; -webkit-transform: rotate(450deg); width: 150px; height: 150px;}
  75% {left: 100%; -webkit-transform: rotate(450deg); width: 150px; height: 150px;}
  100 {right: 100%;}
} 
</style>
  <div class="bar">
  <div class="circle"></div>
  <p>Loading</p>
</div>

</div>
    </div>

</body>
</html>