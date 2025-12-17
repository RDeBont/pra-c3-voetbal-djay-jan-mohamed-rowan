<x-base-layout>
    <main class="toernooi-detail-page">
        <h1>{{ $tournament->name }} - Knockouts</h1>

        @if($knockouts->isEmpty())
            <p>Er zijn nog geen knockout-wedstrijden beschikbaar.</p>
        @else
            <table class="toernooi-tabel">
                <thead>
                    <tr>
                        <th>Team 1</th>
                        <th>Score</th>
                        <th>Team 2</th>
                        <th>Starttijd</th>
                        <th>Eindtijd</th>
                        <th>Veld</th>
                        <th>Scheidsrechter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($knockouts as $fixture)
                        <tr>
                            <td>{{ $fixture->team1->name }}</td>
                            <td>{{ $fixture->team_1_score }} - {{ $fixture->team_2_score }}</td>
                            <td>{{ $fixture->team2->name }}</td>
                            <td>{{ $fixture->start_time }}</td>
                            <td>{{ $fixture->end_time }}</td>
                            <td>{{ $fixture->field }}</td>
                            <td>{{ $fixture->scheidsrechter ? $fixture->scheidsrechter->name : 'Niet toegewezen' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h2>{{ $tournament->name }} - Knockouts</h2>

<table class="table">
    <thead>
        <tr>
            <th>Team 1</th>
            <th>Team 2</th>
            <th>Score</th>
            <th>Veld</th>
            <th>Tijd</th>
        </tr>
    </thead>
    <tbody>
        @foreach($knockouts as $match)
        <tr>
            <td>{{ $match->team1->name }}</td>
            <td>{{ $match->team2->name }}</td>
            <td>{{ $match->team_1_score }} - {{ $match->team_2_score }}</td>
            <td>{{ $match->field }}</td>
            <td>{{ $match->start_time ?? '-' }} - {{ $match->end_time ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

        <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-goback" style="margin-top:20px;">Terug naar toernooi</a>
    </main>
</x-base-layout>
