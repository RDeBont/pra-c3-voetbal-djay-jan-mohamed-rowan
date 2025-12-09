<x-base-layout>
    <main class="toernooien-page">
        <a href="{{ url('/') }}" class="btn-goback">Ga terug</a>

        <h1>Toernooien</h1>

        <form class="filter-form" method="GET" action="{{ route('tournaments.index') }}">
            <label for="sport">Sportsoort:</label>
            <select id="sport" name="sport">
                <option value="">-- Alles --</option>
                <option value="voetbal" {{ request('sport') == 'voetbal' ? 'selected' : '' }}>Voetbal</option>
                <option value="lijnbal" {{ request('sport') == 'lijnbal' ? 'selected' : '' }}>LijnBal</option>
            </select>

            <label for="groep">Groep:</label>
            <select id="groep" name="groep">
                <option value="">-- Alles --</option>
                <option value="groep7" {{ request('groep') == 'groep7' ? 'selected' : '' }}>Groep 7/8</option>
                <option value="brugklas" {{ request('groep') == 'brugklas' ? 'selected' : '' }}>Brugklas</option>
            </select>

            <label for="geslacht">Geslacht:</label>
            <select id="geslacht" name="geslacht">
                <option value="">-- Alles --</option>
                <option value="jongens" {{ request('geslacht') == 'jongens' ? 'selected' : '' }}>Jongens</option>
                <option value="meisjes" {{ request('geslacht') == 'meisjes' ? 'selected' : '' }}>Meisjes</option>
            </select>

            <button type="submit">Filter</button>
            <a href="{{ url('/spelregels') }}" class="btn-spelregels">Spelregels</a>
        </form>

        <section class="toernooi-lijst">

            <table class="toernooi-tabel">
                <thead>
                    <tr>
                        <th>Naam Tournament</th>
                        <th>Details</th>

                        @auth
                            @if(auth()->user()->is_admin)
                                <th>Acties</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tournaments as $tournament)
                        <tr>
                            <td>{{ $tournament->name }}</td>
                            <td>
                                <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-details">
                                    Bekijk details
                                </a>
                            </td>
                            @auth
                                @if(auth()->user()->is_admin)
                                    <td>
                                        <form method="POST" action="{{ route('tournaments.destroy', $tournament->id) }}"
                                            onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-fixture delete">Verwijder</button>
                                        </form>
                                    </td>
                                @endif
                            @endauth

                    @forelse ($tournaments as $tournament)
                        @php
                            $ok = true;

                            // SPORT FILTER
                            if (request('sport') && strtolower($tournament->sport) !== request('sport')) {
                                $ok = false;
                            }

                            // GROEP FILTER (Groep 7 + 8 gecombineerd)
                            if (request('groep')) {
                                $filterGroep = request('groep');
                                $groep = strtolower($tournament->group);

                                if ($filterGroep === 'groep7') {
                                    // Laat zowel groep7 als groep8 zien
                                    if (!in_array($groep, ['groep7', 'groep8'])) {
                                        $ok = false;
                                    }
                                } else {
                                    // Normale match
                                    if ($groep !== $filterGroep) {
                                        $ok = false;
                                    }
                                }
                            }

                            // GESLACHT FILTER
                            if (request('geslacht') && strtolower($tournament->gender) !== request('geslacht')) {
                                $ok = false;
                            }
                        @endphp

                        @if ($ok)
                            <tr>
                                <td>{{ $tournament->name }}</td>
                                <td>
                                    <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-details">
                                        Bekijk details
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="2">Geen toernooien gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </section>
    </main>
</x-base-layout>