        <div class="overlay"></div>
    
        <!-- Sidebar -->
        <nav id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                    @if ($user->can("VIEW_DASHBOARD"))
                    <li class="sidebar-brand"><a href="{{ url('/dashboard') }}">{{ $user->name }} <span class="caret"></span></a></li>

                 @endif

                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>

                @if ($user->can("VIEW_DASHBOARD"))
                    <li class="nav-item"><a class="dropdown-item" href="{{ url('/cart') }}">Shopping Cart</a></li>
                    <li class="nav-item"><a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a></li>
                 @endif

                <!-- Authentication Links -->
                @if ($user->can("VIEW_LOGIN"))
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                @endif

                <li class="nav-item"><a class="nav-link" href="#">CP Connection</a></li> 
                <li class="nav-item"><a class="nav-link" href="#">Catalogues &amp; Flyers</a></li>



                @if ($user->can("VIEW_REGISTER_USER"))
                    <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register New User</a></li>
                @endif

                 @if ($user->can("VIEW_DASHBOARD"))


                    <li class="nav-item"><a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                 @endif

                <!--
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Dropdown heading</li>
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
                -->

                @if ($user->can("ADMIN_APP"))
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                      <span>Admin</span>
                      <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                      </a>
                    </h6>

                    <li><a href="{{url("/admin/inventories")}}">Inventory</a></li>
                    <li><a href="{{url("/admin/vendors")}}">Vendors</a></li>
					<li><a href="{{url("/admin/db")}}">Database</a></li>
					<li><a href="{{url("/admin/orders")}}">Orders</a></li>
					<li><a href="{{url("/admin/application")}}">Application</a></li>
                @endif
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->