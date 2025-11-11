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
            <li><a href="{{ url('/toernooien') }}">Toernooien</a></li>
            <li><a href="{{ url('/inschrijven') }}">Inschrijven</a></li>
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/admin') }}">Admin</a></li>
        </ul>

</footer>

