

<nav id="main-nav" class="navbar navbar-expand">
<!-- Column 1 of 3-->
<div id="search" class="search-form">@include('components.search')</div>

<!-- Column 2 of 3-->
        <div id="brand">
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="/img/logo.png" />
          </a>
        </div>
        <!-- Column 3 of 3-->
      <div class="" id="navigation">
        <ul class="navbar-nav">
		    <!-- Authentication Links -->
              <!--   <li class="nav-item"><a class="nav-link" href="#">CP Connection</a></li> 
              <li class="nav-item"><a class="nav-link" href="#">Catalogues &amp; Flyers</a></li>-->
              <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
            @if ($user->can("VIEW_LOGIN"))
                <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
            @endif
            @if ($user->can("VIEW_REGISTER_USER"))
                <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
            @endif
			     @if ($user->can("VIEW_DASHBOARD"))
                <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard <span class="badge badge-info">{{$processing_count}}</span></a></li>
                <li class="nav-item"><a id="shopping-cart" class="nav-link" href="{{ url('/cart') }}">Cart <span class="badge badge-info">{{$carts_count}}</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}">Logout</a></li>
            @endif
					
        </ul>
      </div>
    </nav>
	

