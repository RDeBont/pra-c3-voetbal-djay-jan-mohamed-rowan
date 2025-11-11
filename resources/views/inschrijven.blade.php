<x-base-layout>
<section class="signupform-wrapper">
    <h2 class="ins">Inschrijven</h2>

    <form method="POST" action="#" class="signupform">
        @csrf

        <!-- Naam School -->
        <div class="signupform-group">
            <label for="school_naam">Naam School</label>
            <input 
                type="text" 
                name="school_naam" 
                id="school_naam" 
                class="signupform-control" 
                placeholder="Bijv. Het College van Breda"
                required
            >
        </div>

        <!-- Adres School -->
        <div class="signupform-group">
            <label for="school_adres">Adres School</label>
            <input 
                type="text" 
                name="school_adres" 
                id="school_adres" 
                class="signupform-control" 
                placeholder="Bijv. Schoolstraat 12, 4811 AB Breda"
                required
            >
        </div>

        <!-- Mailadres Contactpersoon (Coach) -->
        <div class="signupform-group">
            <label for="coach_email">E-mailadres Contactpersoon (Coach)</label>
            <input 
                type="email" 
                name="coach_email" 
                id="coach_email" 
                class="signupform-control" 
                placeholder="Bijv. jan.devries@school.nl"
                required
            >
        </div>

        <!-- E-mailadres van scheidsrechter -->
        <div class="signupform-group">
            <label for="scheidsrechter_email">E-mailadres van Scheidsrechter</label>
            <input 
                type="email" 
                name="scheidsrechter_email" 
                id="scheidsrechter_email" 
                class="signupform-control" 
                placeholder="Bijv. pietjanssen@scheids.nl"
                required
            >
        </div>

        <!-- Toernooien -->
        <div class="signupform-group">
            <label>Toernooien</label>

            <!-- Groep 3/4 -->
            <div signupform-group>
                <input type="checkbox" id="toernooi_groep_34" name="toernooien[]" value="groep_34">
                <label for="toernooi_groep_34">Groep 3/4 Voetbal</label>
                <select name="aantal_groep_34" class="signupform-control mt-1" >
                    <option value="">Aantal teams</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <!-- Groep 7/8 -->
            <div class="mt-2">
                <input type="checkbox" id="toernooi_groep_78" name="toernooien[]" value="groep_78">
                <label for="toernooi_groep_78">Groep 7/8 Voetbal</label>
                <select name="aantal_groep_78" class="signupform-control mt-1" >
                    <option value="">Aantal teams</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <!-- Middelbare school -->
            <div class="mt-2">
                <input type="checkbox" id="toernooi_middelbare" name="toernooien[]" value="middelbare">
                <label for="toernooi_middelbare">Middelbare school Voetbal</label>
                <select name="aantal_middelbare" class="signupform-control mt-1" >
                    <option value="">Aantal teams</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <!-- Meiden Lijnbal -->
            <div class="mt-2">
                <input type="checkbox" id="toernooi_meiden_lijnbal" name="toernooien[]" value="meiden_lijnbal">
                <label for="toernooi_meiden_lijnbal">Meiden Lijnbal (alle groepen)</label>
                <select name="aantal_meiden_lijnbal" class="signupform-control mt-1" >
                    <option value="">Aantal teams</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="signupform-btn mt-3">Inschrijven</button>
    </form>
</section>




</x-base-layout>
