<x-base-layout>
    <section class="signupform-wrapper">
        <h2 class="ins">Nieuw Toernooi Aanmaken</h2>

        <form method="POST" action="{{ route('tournaments.store') }}" class="signupform">
            @csrf

           
            <div class="signupform-group">
                <label for="name">Toernooinaam:</label>
                <input type="text" name="name" id="name" class="signupform-control" required>
            </div>

           
            <div class="signupform-group">
                <label for="school_level">Schoolniveau:</label>
                <select name="school_level" id="school_level" class="signupform-control" required>
                    <option value="">-- Kies niveau --</option>
                    <option value="basisschool">Basisschool</option>
                    <option value="middelbare">Middelbare school</option>
                </select>
            </div>

          
            <div class="signupform-group">
                <label for="sport">Soort sport:</label>
                <select name="sport" id="sport" class="signupform-control" required>
                    <option value="">-- Kies sport --</option>
                    <option value="voetbal">Voetbal</option>
                    <option value="lijnbal">Lijnbal</option>
                </select>
            </div>

         
            <div class="signupform-group">
                <label for="group">Groep:</label>
                <select name="group" id="group" class="signupform-control" required>
                    <option value="">-- Kies groep --</option>
                    <!-- Basisschool -->
                    <option value="groep3-4">Groep 3/4 (gemengd)</option>
                    <option value="groep5-6">Groep 5/6 (gemengd)</option>
                    <option value="groep7-8">Groep 7/8 (gemengd)</option>
                    <option value="groep7-8-lijnbal-meiden">Groep 7/8 Lijnbal Meiden</option>

                   
                    <option value="1e-klasse-jongens">1e klas Jongens/Gemengd</option>
                    <option value="1e-klasse-meiden">1e klas Meiden</option>
                    <option value="1e-klasse-lijnbal-meiden">1e klas Lijnbal Meiden</option>
                </select>
            </div>

           
            <div class="signupform-group">
                <label for="aantal_teams">Aantal teams:</label>
                <select id="aantal_teams" name="aantal_teams" class="signupform-control" required>
                    <option value="">-- Kies aantal --</option>
                    @for($i=1;$i<=5;$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

          
            <div class="signupform-group">
                <label for="team1">Team 1 naam:</label>
                <input type="text" name="team1" id="team1" class="signupform-control" placeholder="Team 1" required>
            </div>
            <div class="signupform-group">
                <label for="team2">Team 2 naam:</label>
                <input type="text" name="team2" id="team2" class="signupform-control" placeholder="Team 2">
            </div>
            <div class="signupform-group">
                <label for="team3">Team 3 naam:</label>
                <input type="text" name="team3" id="team3" class="signupform-control" placeholder="Team 3">
            </div>
            <div class="signupform-group">
                <label for="team4">Team 4 naam:</label>
                <input type="text" name="team4" id="team4" class="signupform-control" placeholder="Team 4">
            </div>
            <div class="signupform-group">
                <label for="team5">Team 5 naam:</label>
                <input type="text" name="team5" id="team5" class="signupform-control" placeholder="Team 5">
            </div>

            <button type="submit" class="signupform-btn mt-3">Maak Toernooi</button>
        </form>
    </section>
</x-base-layout>
