<x-base-layout>
    <section class="signupform-wrapper">
        <h2 class="ins">Contact</h2>

        <form method="POST" action="{{ route('contact.verzenden') }}" class="signupform">
            @csrf

            <!-- Naam -->
            <div class="signupform-group">
                <label for="naam">Naam</label>
                <input 
                    type="text" 
                    name="naam" 
                    id="naam" 
                    class="signupform-control" 
                    placeholder="Bijv. peter de Fries"
                    required
                >
            </div>

            <!-- E-mailadres -->
            <div class="signupform-group">
                <label for="email">E-mailadres</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="signupform-control" 
                    placeholder="Bijv. peter.defries@email.nl"
                    required
                >
            </div>

            <!-- Bericht -->
            <div class="signupform-group">
                <label for="bericht">Bericht</label>
                <textarea 
                    name="bericht" 
                    id="bericht" 
                    rows="6" 
                    class="signupform-control" 
                    placeholder="Typ hier je bericht..."
                    required
                ></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="signupform-btn mt-3">Verzenden</button>
        </form>

        @if(session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif
    </section>
</x-base-layout>
