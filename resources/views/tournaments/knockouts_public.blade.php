<x-base-layout>
<main class="toernooi-detail-page">

    <h1>Knockouts - {{ $tournament->name }}</h1>

    <div class="top-buttons" style="margin-bottom: 20px; display: flex; justify-content: center;">
        <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-goback">
            Terug naar Toernooi
        </a>
    </div>

    @foreach ($knockouts as $fixture)
        <div class="fixture-wrapper" style="margin-bottom: 20px;">
            <table class="toernooi-tabel">
                <tbody>
                    <tr>
                        <th>Team 1:</th>
                        <td>{{ $fixture->team1->name }}</td>
                        <td>{{ $fixture->team_1_score }}</td>
                    </tr>
                    <tr>
                        <th>Team 2:</th>
                        <td>{{ $fixture->team2->name }}</td>
                        <td>{{ $fixture->team_2_score }}</td>
                    </tr>
                    <tr>
                        <th>Ronde:</th>
                        <td colspan="2">{{ $fixture->round }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

</main>
</x-base-layout>
