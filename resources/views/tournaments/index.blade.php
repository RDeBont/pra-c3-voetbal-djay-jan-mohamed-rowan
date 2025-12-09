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
                <option value="groep7" {{ request('groep') == 'groep7' ? 'selected' : '' }}>Groep 7</option>
                <option value="groep8" {{ request('groep') == 'groep8' ? 'selected' : '' }}>Groep 8</option>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tournaments as $tournament)
                        @php
                            $ok = true;

                            if (request('sport') && strtolower($tournament->sport) !== request('sport')) {
                                $ok = false;
                            }
                            if (request('groep') && strtolower($tournament->group) !== request('groep')) {
                                $ok = false;
                            }
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
