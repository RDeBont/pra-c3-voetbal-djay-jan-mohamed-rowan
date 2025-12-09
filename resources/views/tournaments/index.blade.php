<x-base-layout>
    <main class="toernooien-page">
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

                <option value="groep3_4" {{ request('groep') == 'groep3_4' ? 'selected' : '' }}>Groep 3/4</option>
                <option value="groep5_6" {{ request('groep') == 'groep5_6' ? 'selected' : '' }}>Groep 5/6</option>
                <option value="groep7" {{ request('groep') == 'groep7' ? 'selected' : '' }}>Groep 7/8</option>

                <option value="klas1_jongens" {{ request('groep') == 'klas1_jongens' ? 'selected' : '' }}>Klas 1 (Jongens)</option>
                <option value="klas1_meiden" {{ request('groep') == 'klas1_meiden' ? 'selected' : '' }}>Klas 1 (Meiden)</option>
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
                    </tr>
                </thead>
                <tbody>

                    @forelse ($tournaments as $tournament)
                        @php
                            $ok = true;

                            // SPORT FILTER
                            if (request('sport') && strtolower($tournament->sport) !== request('sport')) {
                                $ok = false;
                            }

                            // GROEP FILTER – inclusief combinatie Groep 7/8
                            if (request('groep')) {
                                $filter = request('groep');
                                $groep = strtolower($tournament->group);

                                // Groep 7/8 = groep7 + groep8 tonen
                                if ($filter === 'groep7') {
                                    if (!in_array($groep, ['groep7', 'groep8'])) {
                                        $ok = false;
                                    }
                                }
                                // groep3/4
                                else if ($filter === 'groep3_4') {
                                    if (!in_array($groep, ['groep3', 'groep4'])) {
                                        $ok = false;
                                    }
                                }
                                // groep5/6
                                else if ($filter === 'groep5_6') {
                                    if (!in_array($groep, ['groep5', 'groep6'])) {
                                        $ok = false;
                                    }
                                }
                                // klas 1 jongens
                                else if ($filter === 'klas1_jongens') {
                                    if ($groep !== 'klas1_jongens') {
                                        $ok = false;
                                    }
                                }
                                // klas 1 meiden
                                else if ($filter === 'klas1_meiden') {
                                    if ($groep !== 'klas1_meiden') {
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
