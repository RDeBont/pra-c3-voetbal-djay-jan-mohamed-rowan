<x-base-layout>
  
  @if(session('success'))
    <div class="alert alert-success" id="successMessage"
      style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 12px; border-radius: 4px; margin-bottom: 20px; color: #155724;">
      {{ session('success') }}
    </div>
  @endif

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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const successMessage = document.getElementById('successMessage');
      if (successMessage) {
        setTimeout(function () {
          successMessage.style.transition = 'opacity 0.5s ease-out';
          successMessage.style.opacity = '0';
          setTimeout(function () {
            successMessage.style.display = 'none';
          }, 500);
        }, 5000);
      }
    });
  </script>

</x-base-layout>