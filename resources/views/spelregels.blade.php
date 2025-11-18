<x-base-layout>
  <main class="spelregels-page">
    <h1>Spelregels</h1>

    <p>Op deze pagina komen de spelregels per toernooi. Deze informatie wordt binnenkort toegevoegd.</p>
    <div class="dropdowns">
      <label for="klas">Klas:</label>
      <select id="klas" name="klas" class="dropdown">
        <option value="">-- Kies een klas --</option>
        <option value="klas1">groep 7 </option>
        <option value="klas2">groep 8</option>
        <option value="klas3">brugklas</option>
      </select>

      <label for="spel">Spel:</label>
      <select id="spel" name="spel" class="dropdown">
        <option value="">-- Kies een spel --</option>
        <option value="voetbal">Voetbal</option>
        <option value="lijnbal">Lijnbal</option>
      </select>
    </div>

    <ul>
      <li>Voetbaltoernooi – regels volgen KNVB-jeugdregels</li>
      <li>Lijnbaltoernooi – regels worden nog aangeleverd</li>
    </ul>
  </main>
</x-base-layout>
