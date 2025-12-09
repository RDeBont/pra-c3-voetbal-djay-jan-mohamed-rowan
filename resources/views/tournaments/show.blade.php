<x-base-layout>
    <main class="toernooi-detail-page">
        <h1>{{ $tournament->name }}</h1>
        <div class="wn">
            <h2>Alle Wedstrijden</h2>
        </div>


        @foreach ($fixtures as $fixture)
            <table class="toernooi-tabel" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <th>Team 1:</th>
                        <td>{{ $fixture->team1->name }}</td>
                        <td>{{ $fixture->team_1_id }}</td>

                    </tr>
                    <tr>
                        <th>Score:</th>
                        <td>{{ $fixture->team_1_score }} - {{ $fixture->team_2_score }}</td>
                        <td></td>

                    </tr>
                    <tr>
                        <th>Team 2:</th>
                        <td>{{ $fixture->team2->name }}</td>
                        <td>{{ $fixture->team_2_id }}</td>

                    </tr>
                    <tr>
                        <th>StartTijd</th>
                        <td>{{ $fixture->start_time }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Fase</th>
                        <td>{{ $fixture->type }}</td>
                        <td></td>


                </tbody>
            </table>
            @auth
                @if(auth()->user()->is_admin)
                    <div class="fixture-buttons">
                        <a href="{{ route('fixtures.edit', $fixture->id) }}" class="btn-fixture edit">
                            Aanpassen
                        </a>

                        <form method="POST" action="{{ route('fixtures.destroy', $fixture->id) }}"
                            onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-fixture delete">Verwijderen</button>
                        </form>
                    </div>
                @endif
            @endauth

        @endforeach

    </main>
    
</x-base-layout>


