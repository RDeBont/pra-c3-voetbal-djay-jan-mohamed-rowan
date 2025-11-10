<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
  @include('header')

  <main class="homepage">
    <section class="hero">
      <h1>Schrijf je school nu in!</h1>
      <p>Doe mee aan spannende schooltoernooien en laat je team schitteren!</p>
      <a href="{{ url('/inschrijven') }}" class="btn-inschrijven">Inschrijven</a>
    </section>

    <section class="info">
      <h2>Info</h2>
      <p>moet nog ingevuld worden met email enzv</p>
    </section>
  </main>
</body>
</html>
