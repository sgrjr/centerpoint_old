<h1> Credentials Tester</h1>

@if($response->user)

Credentials Work!
<li>{{$response->user->UNAME}}</li>
<li>{{$response->user->EMAIL}}</li>
<li>{{$response->user->SNAME}}</li>
<li>{{$response->user->MPASS}}</li>
<li>{{$response->user->ORGNAME}}</li>

@else

invalid login!

@endif