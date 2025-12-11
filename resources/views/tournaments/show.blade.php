<x-base-layout>
    <main class="toernooi-detail-page">
        <h1>{{ $tournament->name }}</h1>
        <div class="wn">
            <h2>Alle Wedstrijden</h2>
        </div>

        <!-- Pool Filter -->
        <div style="margin-bottom: 20px; display: flex; justify-content: center;">
            <label for="pool-filter" style="font-weight: bold; margin-right: 10px; ">Filter op Poule:</label>
            <select id="pool-filter" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">Alle Poules</option>
                @php
                    $pools = collect($fixtures)->map(fn($f) => $f->team1->pool)->unique()->sort();
                @endphp
                @foreach ($pools as $pool)
                    <option value="{{ $pool }}">Poule {{ $pool }}</option>
                @endforeach
            </select>
        </div>

        @foreach ($fixtures as $fixture)
        
        <!-- WRAPPER die tabel + knop bevat -->
        <div class="fixture-wrapper" data-fixture-pool="{{ $fixture->team1->pool }}" style="margin-bottom: 20px;">

            <table class="toernooi-tabel" style="margin-bottom: 10px;">
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
                        <th>Veld</th>
                        <td>{{ $fixture->field }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Poule</th>
                        <td>{{ $fixture->team1->pool }}</td>
                        <td></td>
                    </tr>
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

            @if (Auth::check() && Auth::user()->is_admin)
            <div class="edit-button-wrapper">
                <a href="{{ route('fixtures.edit', $fixture->id) }}" class="edit-button">
                    Wedstrijd Aanpassen
                </a>
            </div>
            @endif

        </div>
        @endforeach

    </main>

    <script>
        document.getElementById('pool-filter').addEventListener('change', function() {
            const selectedPool = this.value;
            const fixtures = document.querySelectorAll('.fixture-wrapper');

            fixtures.forEach(wrapper => {
                const fixturePool = wrapper.getAttribute('data-fixture-pool');
                wrapper.style.display = (selectedPool === '' || fixturePool === selectedPool)
                    ? 'block'
                    : 'none';
            });
        });
    </script>
</x-base-layout>


