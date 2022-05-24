@extends('layouts.app')

@section('content')

<div class="container">
 <form class="form-signin" method="POST" action="{{ url('/login') }}">
		{{ csrf_field() }}

      <h1 class="">Login</h1>
      
	   <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			<label for="email" class="control-label">E-Mail Address</label>

				<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

				@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				@endif
		</div>

		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			<label for="password" class="control-label">Password</label>

				<input id="password" type="password" class="form-control" name="password">

				@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				@endif

		</div>
	  
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
	  
	 <div class="form-group">
			<button type="submit" class="btn btn-primary">
				<i class="fa fa-btn fa-sign-in"></i> Login
			</button>

			<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
	</div>
						
    </form>
</div>
@endsection
