<header class="navbar">
  <nav class="nav-container">
    <div class="logo">
      <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
      </a>
    </div>
    <ul class="nav-links">
      <li><a href="{{ url('/') }}">Home</a></li>
      <li><a href="{{ url('/contact') }}">Contact</a></li>
      <li><a href="{{ route('tournaments.index')}}">Toernooien</a></li>
      <li><a href="{{ url('/inschrijven') }}">Inschrijven</a></li>
      <l1><a href="{{ route('team.index') }}">Team aanmelden</a></l1>
      <li><a href="{{ url('/login') }}">Login</a></li>
      <li><a href="{{ route('admin.index')}}">Admin</a></li>
    </ul>
  </nav>
</header>
