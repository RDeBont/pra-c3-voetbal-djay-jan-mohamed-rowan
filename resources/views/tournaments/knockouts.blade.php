<x-base-layout>
<main class="toernooi-detail-page">
    <h1>{{ $tournament->name }} - Knockouts</h1>

    <form action="{{ route('tournaments.advanceKnockouts', $tournament->id) }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <button type="submit" class="btn btn-sm btn-success">Advance Winners</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $rounds = $knockouts->groupBy('round');
    @endphp

    @if($knockouts->isEmpty())
        <p>Er zijn nog geen knockout-wedstrijden beschikbaar.</p>
    @else
        <hr style="margin: 40px 0;">
        <h2>Knockout Bracket</h2>

        <div class="bracket-container">
            <div class="bracket-grid">
                @foreach($rounds as $roundName => $roundFixtures)
                    <div class="round-column">
                        <h3>{{ $roundName }}</h3>
                        @foreach($roundFixtures as $fixture)
                            <div class="match-box">
                                {{-- Team 1 --}}
                                <div class="team {{ is_null($fixture->team1) ? 'bye' : '' }}">
                                    {{ $fixture->team1?->name ?? 'Bye' }} ({{ $fixture->team_1_score ?? '-' }})
                                </div>

                                <div class="vs">vs</div>

                                {{-- Team 2 --}}
                                <div class="team {{ is_null($fixture->team2) ? 'bye' : '' }}">
                                    {{ $fixture->team2?->name ?? 'Bye' }} ({{ $fixture->team_2_score ?? '-' }})
                                </div>

                                <div class="time">{{ $fixture->start_time ?? '-' }} - {{ $fixture->end_time ?? '-' }}</div>

                                {{-- Aanpassen-knop --}}
                                @if($fixture->team1 || $fixture->team2)
                                    <a href="{{ route('fixtures.edit', $fixture->id) }}" class="btn btn-sm btn-primary" style="margin-top:5px;">Aanpassen</a>
                                @endif

                                {{-- Verwijderen-knop --}}
                                @if($fixture)
                                <form action="{{ route('fixtures.destroy', $fixture->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="margin-top:5px;">Verwijderen</button>
                                </form>
                                @endif

                                {{-- Winnaarvak --}}
                                @php
                                    $winner = null;
                                    if(!is_null($fixture->team_1_score) && !is_null($fixture->team_2_score)) {
                                        if(($fixture->team_1_score ?? 0) > ($fixture->team_2_score ?? 0)) $winner = $fixture->team1?->name ?? '-';
                                        if(($fixture->team_2_score ?? 0) > ($fixture->team_1_score ?? 0)) $winner = $fixture->team2?->name ?? '-';
                                    }
                                @endphp
                                @if($winner)
                                    <div class="winner-box">{{ $winner }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-goback" style="margin-top:20px;">Terug naar toernooi</a>
</main>

<style>
.bracket-container {
    overflow-x: auto;
    padding-bottom: 50px;
}

.bracket-grid {
    display: flex;
    gap: 50px;
    align-items: flex-start;
}

.round-column {
    display: flex;
    flex-direction: column;
    gap: 40px;
    min-width: 200px;
    position: relative;
}

.round-column h3 {
    text-align: center;
    margin-bottom: 10px;
}

.match-box {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 8px;
    text-align: center;
    position: relative;
    background: #f8f8f8;
}

.match-box .team {
    font-weight: bold;
}

.match-box .team.bye {
    color: #999;
    font-style: italic;
}

.match-box .vs {
    margin: 3px 0;
    font-size: 0.9rem;
    color: #555;
}

.match-box .time {
    font-size: 0.8rem;
    margin-top: 2px;
    color: #777;
}

.btn {
    display: inline-block;
    padding: 3px 8px;
    font-size: 0.8rem;
    border-radius: 3px;
    text-decoration: none;
    color: #fff;
    background-color: #4f7158ff;
}

.winner-box {
    margin-top: 5px;
    padding: 3px 5px;
    background-color: #d4edda;
    border: 1px solid #28a745;
    border-radius: 4px;
    font-weight: bold;
    color: #155724;
}

/* Lijnen tussen rondes */
.round-column:not(:last-child) .match-box::after {
    content: "";
    position: absolute;
    right: -25px;
    top: 50%;
    width: 25px;
    height: 2px;
    background: #000;
}
</style>
</x-base-layout>
