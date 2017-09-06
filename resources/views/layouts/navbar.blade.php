<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">

    <!-- Branding Image -->
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>

    <!-- Collapsed Hamburger -->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    {{-- collapsible content --}}
    <div class="collapse navbar-collapse" id="app-navbar-collapse">


      <ul class="navbar-nav mr-auto">

        <!-- Authentication Links -->
        @guest
          <li nav-item><a class="nav-link{{ Request::is('*login') ? ' active' : '' }}" href="{{ route('login') }}">Login</a></li>

          <li nav-item><a class="nav-link{{ Request::is('*register') ? ' active' : '' }}" href="{{ route('register') }}">Register</a></li>


        @else
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('chat') }}">Chat <span class="sr-only">(current)</span></a>
          </li>

          <li class="nav-item dropdown">
            <a href="#" id="show-user-name" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu">
              <a href="{{ route('logout') }}" class="dropdown-item"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </li>

        @endguest

      </ul>


      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
      </ul>

    </div> {{-- collapse --}}


  </div> {{-- container --}}
</nav>
