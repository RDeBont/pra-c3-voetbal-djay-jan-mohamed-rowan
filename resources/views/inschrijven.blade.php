<x-base-layout>
    <section class="signupform-wrapper">
        <h2 class="ins">Inschrijven</h2>

        <form method="POST" action="{{ route('inschrijven.store') }}" class="signupform">
            @csrf

            <!-- Naam School -->
            <div class="signupform-group">
                <label for="name">Naam School</label>
                <input type="text" name="name" id="name" class="signupform-control"
                    placeholder="Bijv. Het College van Breda" value="{{ old('name') }}" required>
            </div>

            <!-- Adres School -->
            <div class="signupform-group">
                <label for="address">Adres School</label>
                <input type="text" name="address" id="address" class="signupform-control"
                    placeholder="Bijv. Schoolstraat 12, 4811 AB Breda" value="{{ old('address') }}" required>
            </div>

            <!-- Email -->
            <div class="signupform-group">
                <label for="email">E-mailadres</label>
                <input type="email" name="email" id="email" class="signupform-control"
                    placeholder="Bijv. contact@school.nl" value="{{ old('email') }}" required>
            </div>

            <!-- School Type -->
            <div class="signupform-group">
                <label for="typeSchool">School soort</label>
                <select name="typeSchool" id="typeSchool" class="signupform-control" required>
                    <option value="">Selecteer school soort</option>
                    <option value="basisschool" {{ old('typeSchool') === 'basisschool' ? 'selected' : '' }}>Basisschool</option>
                    <option value="middelbare school" {{ old('typeSchool') === 'middelbare school' ? 'selected' : '' }}>Middelbare school</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit" class="signupform-btn mt-3">Inschrijven</button>
        </form>
    </section>
</x-base-layout>