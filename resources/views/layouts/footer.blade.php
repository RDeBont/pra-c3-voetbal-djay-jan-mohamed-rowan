<footer class="footer">
    <h1>Algemene Informatie</h1>
    <div class="blackLine"></div>

    <div class="footer-container">
        <div class="footer-section">
            <h2>Bedrijfsinformatie</h2>
            <p>KvK Breda: </p>
        </div>

        <div class="footer-section">
            <h2>Contactgegevens</h2>
            <p>E-mail: info@bedrijf.nl</p>
            <p>Telefoonnummer: 0612345678</p>
            <p>Adres & Plaats : Roosendaalsebaan 21, Roosendaal</p>
            <p>Postcode: 4505ZX</p>
        </div>

    </div>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
        </a>
    </div>

    <div class="footer-container_2">
        <ul class="nav-links">
      <li><a href="{{ url('/') }}">Home</a></li>
      <li><a href="{{ url('/contact') }}">Contact</a></li>
      <li><a href="{{ route('tournaments.index')}}">Toernooien</a></li>
      @guest
      <li><a href="{{ url('/inschrijven') }}">Inschrijven</a></li>
      @endguest

      @auth
        <li><a href="{{ route('team.index') }}">Team aanmelden</a></li>
      @endauth

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

      @auth
        @if(auth()->user()->is_admin == 1)
          <li><a href="{{ route('admin.index') }}">Admin</a></li>
        @endif
      @endauth


    </ul>

</footer>

