<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Center Point Large Print') }}</title>

    <!-- Fonts -->

    <!-- Styles -->

    @yield('head')
</head>
<body>

    <div id="app">
        @yield('content')
    </div>

<script>
    function loadDoc() {
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        document.getElementById("demo").innerHTML = this.responseText;
        console.log(this)
        }
      xhttp.open("post", "https://centerpointlargeprint.com/foxisapi/foxisapi.dll/webnet.gate.startpoint", true);

      //bzp%3DMAINMENU%26z01%3Dstephenreynolds%26z02%3Dsunshine%26z03%3D0498600000003%26z04%3D67035%26HEADER_FILE%3DWEBHEAD%26DETAIL_FILE%3DWEBDETAIL%26ORDER_TRANSNO%3D%26

      const bzp = [
        "GENERAL_VIEW",
        ""
      ];
      const params = 'bzp=GENERAL_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=67035%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26'

      xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');            

      xhttp.send(params);
    }

</script>
</body>
</html>

<!-- 

    [
                  "x" => 146,
                  "y" => 38,
                  "ISBN" => "9781638083665=3",
                  "bzp"=>"TD_TITLE_WRITE",
                  "INVLMNT"=> "",
                  "z01"=> "stephenreynolds",
                  "z02"=> "sunshine",
                  "z03"=> "0498600000003",
                  "RETURNPAGE"=> "TD_TITLE_VIEW",
                  "PASSZREC"=> "",
                  "SEARCHBY"=> "BYTITLE",
                  "SORTBY"=> "BYAUTHORS",
                  "MULTIBUY"=> "ON",
                  "FULLVIEW"=> "ON",
                  "SKIPBOUGHT"=> "ON",
                  "OUTOFPRINT"=> "ON",
                  "OPROCESS"=> "ON",
                  "OADDTL"=> "ON",
                  "OVIEW"=> "ON",
                  "ORHIST"=> "ON",
                  "INSOS"=> "OFF",
                  "INREG"=> "OFF",
                  "OINVO"=> "OFF",
                  "EXTZN"=> "OFF",
                  "OBEST"=> "ON",
                  "ADVERTISE"=> "ON",
                  "DEFAULTPER"=> ""
                ]

                -->