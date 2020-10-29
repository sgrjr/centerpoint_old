<!doctype html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('server-side-css')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Center Point Large Print') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>

    <script>
      window.INITIAL_STATE= <?php echo $initial_state ?? "{viewer:{}}" ;?>
  	</script>

    <div id="app">
        @yield('content')
    </div>

</body>
</html>
=======
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <link rel="icon" href="/favicon.ico"/>
    <meta name="viewport" content="minimum-scale=1,width=device-width,initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/manifest.json"/>

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"/>
    
    <title>Center Point Large Print</title>
    @yield('head')
  </head>
  <body id="cp">
    @yield('content')
  </body>
</html>
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
