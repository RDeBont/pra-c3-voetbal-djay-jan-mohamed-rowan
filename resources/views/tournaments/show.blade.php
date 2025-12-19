<x-base-layout>
<main class="toernooi-detail-page">

    <h1>{{ $tournament->name }}</h1>

    <!-- Top Buttons -->
    <div class="top-buttons" style="margin-bottom: 20px; display: flex; justify-content: center;">
        <a href="{{ route('tournaments.index') }}" class="btn-goback">
            Ga Terug
        </a>
    </div>

    <!-- Knockout Knoppen -->
    <div class="knockout-container"
         style="margin-bottom: 20px; display: flex; justify-content: center; flex-direction: column; align-items: center; gap: 10px;">

        @auth
            @if(auth()->user()->is_admin)
                <!-- Form voor Genereer + Start Knockouts -->
                <form id="knockoutForm"
                      action="{{ route('tournaments.generateKnockouts', $tournament->id) }}"
                      method="POST"
                      class="knockout-form"
                      style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                    @csrf

                    <button type="button" id="generateBtn" class="btn btn-primary">
                        Genereer Knockouts
                    </button>

                    <!-- Verborgen input voor aantal teams per poule -->
                    <div class="teams-input"
                         style="display: none; flex-direction: column; align-items: center; gap: 10px; margin-top: 10px;">
                        <label for="teamsPerPool" style="font-weight: bold;">
                            Aantal teams per poule dat doorgaat:
                        </label>

                        <input type="number"
                               id="teamsPerPool"
                               name="teamsPerPool"
                               min="1"
                               required
                               style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">

                        <button type="submit" class="btn btn-primary">
                            Start Knockouts
                        </button>
                    </div>
                </form>

                <a href="{{ route('tournaments.knockouts', $tournament->id) }}"
                   class="btn btn-primary"
                   style="margin-top: 10px;">
                    Bekijk Knockouts
                </a>
            @else
                <!-- Ingelogde niet-admin: alleen Bekijk Knockouts -->
                <a href="{{ route('tournaments.knockouts.public', $tournament->id) }}"
                   class="btn btn-primary"
                   style="margin-top: 10px;">
                    Bekijk Knockouts
                </a>
            @endif
        @endauth

        @guest
            <!-- Niet ingelogd: Bekijk Knockouts -->
            <a href="{{ route('tournaments.knockouts.public', $tournament->id) }}"
               class="btn btn-primary"
               style="margin-top: 10px;">
                Bekijk Knockouts
            </a>
        @endguest

    </div>

    <div class="wn">
        <h2>Alle Wedstrijden</h2>
    </div>

    <!-- Pool Filter -->
    <div style="margin-bottom: 20px; display: flex; justify-content: center;">
        <label for="pool-filter" style="font-weight: bold; margin-right: 0.5rem; margin-top: 0.55rem">
            Filter op Poule:
        </label>
        <select id="pool-filter" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            <option value="">Alle Poules</option>
            @php
                $pools = collect($fixtures)
                    ->map(fn($f) => $f->team1->pool)
                    ->filter()
                    ->unique()
                    ->sort(fn($a, $b) => $a <=> $b);
            @endphp
            @foreach ($pools as $pool)
                <option value="{{ $pool }}">Poule {{ $pool }}</option>
            @endforeach
        </select>

        <a href="{{ route('tournaments.standings', $tournament->id) }}" class="btn-goback" style="margin-left: 20px;">
            Stand
        </a>
    </div>

    <!-- Wedstrijden Lijst -->
    @foreach ($fixtures as $fixture)
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
                        <td>{{ $fixture->end_time }}</td>
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
                    <tr>
                        <th>Scheidsrechter</th>
                        <td>{{ $fixture->scheidsrechter ? $fixture->scheidsrechter->name : 'Niet toegewezen' }}</td>
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

        </div>
    @endforeach

</main>

<script>
    const generateBtn = document.getElementById('generateBtn');
    const teamsInput = document.querySelector('.teams-input');

    if(generateBtn){
        generateBtn.addEventListener('click', () => {
            teamsInput.style.display = 'flex';
            generateBtn.style.display = 'none';
        });
    }

    document.getElementById('pool-filter').addEventListener('change', function () {
        const selectedPool = this.value;
        document.querySelectorAll('.fixture-wrapper').forEach(wrapper => {
            const pool = wrapper.getAttribute('data-fixture-pool');
            wrapper.style.display = (selectedPool === '' || pool === selectedPool) ? 'block' : 'none';
        });
    });
</script>
</x-base-layout>
