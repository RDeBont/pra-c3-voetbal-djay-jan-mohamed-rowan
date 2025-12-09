<header class="navbar">
  <nav class="nav-container">
    <div class="logo">
      <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
      </a>
    </div>
    <ul class="nav-mid">
      <li><a href="{{ url('/') }}">Home</a></li>
      <li><a href="{{ url('/contact') }}">Contact</a></li>
      <li><a href="{{ route('tournaments.index')}}">Toernooien</a></li>
      @guest
        <li><a href="{{ url('/inschrijven') }}">Inschrijven</a></li>
      @endguest

      @auth
        @if(auth()->user()->is_admin == 0)

          <li><a href="{{ route('team.index') }}">Team aanmelden</a></li>
        @endif
      @endauth

      @auth
        @if(auth()->user()->is_admin == 1)
          <li><a href="{{ route('admin.index') }}">Admin</a></li>
        @endif
      @endauth
    </ul>

    <ul class="nav-right">

      @guest
        <li><a href="{{ url('/login') }}">Login</a></li>
      @endguest

      @auth
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <li>
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
              Log uit
            </a>
          </li>
        </form>
      @endauth


    </ul>


  </nav>
</header>
