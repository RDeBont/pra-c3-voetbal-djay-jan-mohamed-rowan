<x-base-layout>

    
    <main class="fixture-edit">
        
        <h1>Wedstrijd aanpassen</h1>
        <h2>{{ $fixture->team1->name }} vs {{ $fixture->team2->name }}</h1>
        <h3>{{ $fixture->type  }}</h1>

        <form action="{{ route('fixtures.update', $fixture->id) }}" method="POST">
            @csrf
            @method('PUT')

    
            <div class="form-group">
                <label for="team_1_score">Score Team 1:</label>
                <input type="number" id="team_1_score" name="team_1_score" value="{{ $fixture->team_1_score }}" required>
            </div>
            <div class="form-group">
                <label for="team_1_points">Punten Toekenning:</label>
                <input type="number" id="team_1_points" name="team_1_points" value="{{ $fixture->team1->poulePoints }}" required>
            </div>
            <div class="form-group">
                <label for="team_2_score">Score Team 2:</label>
                <input type="number" id="team_2_score" name="team_2_score" value="{{ $fixture->team_2_score }}" required>
            </div>
            <div class="form-group">
                <label for="team_2_points">Punten Toekenning:</label>
                <input type="number" id="team_2_points" name="team_2_points" value="{{ $fixture->team2->poulePoints }}" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Tijd:</label>
               <input type="time" id="start_time" name="start_time" value="{{ date('H:i', strtotime($fixture->start_time)) }}" required>
            </div>
            <button type="submit" class="btn-update-score">Update Wedstrijd</button>
        </form>
                
    </main>
    
</x-base-layout>