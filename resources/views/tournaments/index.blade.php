<x-base-layout>
    <main class="toernooien-page">


        <h1>Toernooien</h1>
        <a href="{{ url('/spelregels') }}" class="btn-spelregels">Spelregels</a>


        <section class="toernooi-lijst">
            <table class="toernooi-tabel">
                
                <thead>
                    <tr>
                        <th>Naam Tournament</th>
                        <th>Details</th>

                        @auth
                            @if (auth()->user()->is_admin)
                                <th>Acties</th>
                            @endif
                        @endauth
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tournaments as $tournament)
                        <tr>
                            <td>{{ $tournament->name }}</td>
                            <td>
                                <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-details">
                                    Bekijk details
                                </a>
                            </td>

                            @auth
                                @if (auth()->user()->is_admin)
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Geen toernooien gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </main>
</x-base-layout>
