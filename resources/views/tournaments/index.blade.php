<x-base-layout>
    <main class="toernooien-page">
        <h1>Toernooien</h1>


        <form class="filter-form">
            <label for="sport">Sportsoort:</label>
            <select id="sport" name="sport">
                <option>Voetbal</option>
                <option>LijnBal</option>
            </select>

            <label for="groep">Groep:</label>
            <select id="groep" name="groep">
                <option>Groep 7</option>
                <option>Groep 8</option>
                <option>Brugklas</option>
            </select>

            <label for="geslacht">Geslacht:</label>
            <select id="geslacht" name="geslacht">
                <option>Jongens</option>
                <option>Meisjes</option>
            </select>
            <button type="submit">Filter</button>
            <a href="{{ url('/spelregels') }}" class="btn-spelregels">Spelregels</a>

        </form>

        <section class="toernooi-lijst">
            <table class="toernooi-tabel">
                <thead>
                    <tr>
                        <th>Naam Tournament</th>
                        <th>Details</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tournaments as $tournament)
                        <tr>
                            <td>{{ $tournament->name }}</td>


                            <td>
                                <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-details">
                                    Bekijk details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</x-base-layout>
