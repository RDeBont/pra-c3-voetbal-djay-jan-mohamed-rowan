<x-base-layout>
    <main class="toernooi-detail-page">
        <h1>{{ $tournament->name }}</h1>

        <table class="toernooi-tabel">
            <tbody>
                <tr>
                    <th>Datum Plaatsvinding</th>
                    <td>{{ $tournament->date }}</td>
                </tr>
                <tr>
                    <th>Veldnummer</th>
                    <td>{{ $tournament->fields_amount }}</td>
                </tr>
                <tr>
                    <th>Tijdsduur</th>
                    <td>{{ $tournament->game_length_minutes }}</td>
                </tr>
                <tr>
                    <th>Teamnummer</th>
                    <td>{{ $tournament->amount_teams_pool }}</td>
                </tr>
            </tbody>
        </table>
    </main>
</x-base-layout>
