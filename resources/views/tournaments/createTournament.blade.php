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
                    <!-- Basisschool (Voetbal) -->
                    <option value="groep3/4">Groep 3/4 (gemengd)</option>
                    <option value="groep5/6" >Groep 5/6 (gemengd)</option>
                    <option value="groep7/8" >Groep 7/8 (gemengd)</option>
                    <!-- Basisschool (Lijnbal) -->
                    <option value="groep7/8" >Groep 7/8 Lijnbal Meiden</option>

                    <!-- Middelbare school (Voetbal) -->
                    <option value="klas1_jongens" >1e klas Jongens/Gemengd</option>
                    <option value="klas1_meiden" >1e klas Meiden</option>

                    <!-- Middelbare school (Lijnbal) -->
                    <option value="klas1_meiden" >1e klas Lijnbal Meiden</option>
                </select>
            </div>

           
             <button type="submit" class="signupform-btn mt-3">Maak Toernooi</button>

          
        </form>
    </section>
</x-base-layout>
