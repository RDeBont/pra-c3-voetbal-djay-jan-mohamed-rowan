<x-base-layout>
    <main class="toernooien-page">
        <h1>Toernooien</h1>

        <a href="{{ url('/spelregels') }}" class="btn-spelregels">Spelregels</a>

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
        </form>

        <section class="toernooi-lijst">
            <table class="toernooi-tabel">
                <thead>
                    <tr>
                        <th>Naam Tournament</th>
                        <th>Datum Plaatsvinding</th>
                        <th>Veldnummer</th>
                        <th>Tijdsduur</th>
                        <th>Teamnummer</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tournaments as $tournament)
                        <tr>
                            <td>{{ $tournament->name }}</td>
                            <td>{{ $tournament->date }}</td>
                            <td>{{ $tournament->fields_amount }}</td>
                            <td>{{ $tournament->game_length_minutes}}</td>
                            <td>{{ $tournament->amount_teams_pool}}</td>
                            <td><a href="{{ url('/toernooi-detail') }}" class="btn-details">Bekijk details</a></td>

                        </tr>
                </tbody>
                @endforeach
            </table>
        </section>
    </main>
</x-base-layout>
