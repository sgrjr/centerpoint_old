<h1> Authorized User Session</h1>

@if($response->user)

Logged in User
<li>{{$response->user->UNAME}}</li>
<li>{{$response->user->EMAIL}}</li>
<li>{{$response->user->SNAME}}</li>
<li>{{$response->user->MPASS}}</li>
<li>{{$response->user->ORGNAME}}</li>

@else

Not logged in

@endif