<x-base-layout>
    <main class="adminPage">
         @if (session('success'))
        <div class="admin-message">
        {{ session('success') }}

        @endif
        </div>


        <div class="tInfoContainer">
            <h2>Admin Panel</h2>
            <p>Hier kunt u wedstrijden beheren en aanmaken.</p>
        </div>
        <div class="butten">
            <a href="{{ route('tournaments.create') }}">Maak toernooi</a>
        </div>

        <div class="infoContainer">
            <div class="wedstrijdCard">
                <h3>Wedstrijd 1</h3>
                <p>Datum: 15 maart 2024</p>
                <p>Locatie: Sportpark Rozenoord</p>
                <button>Bewerk</button>
                <button>Verwijder</button>
            </div>
            <div class="wedstrijdCard">
                <h3>Wedstrijd 1</h3>
                <p>Datum: 15 maart 2024</p>
                <p>Locatie: Sportpark Rozenoord</p>
                <button>Bewerk</button>
                <button>Verwijder</button>
            </div>
            <div class="wedstrijdCard">
                <h3>Wedstrijd 1</h3>
                <p>Datum: 15 maart 2024</p>
                <p>Locatie: Sportpark Rozenoord</p>
                <button>Bewerk</button>
                <button>Verwijder</button>
            </div>
        </div>

        <div class="blackLine"></div>

        <div class="tInfoContainer">
            <h2>Ingeschreven scholen</h2>
        </div>
        <div class="infoContainer">
            @forelse($schools as $school)
                <div class="userCard">
                    <h3>{{ $school->name }}</h3>
                    <p>Email: {{ $school->email }}</p>
                    <p>Type school: {{ $school->typeSchool }}</p>
                    <p>Address: {{ $school->address }}</p>
                    <form method="POST" action="{{ route('admin.schools.accept', $school->id) }}" style="display:inline">
                        @csrf
                        <button type="submit">Accepteer</button>
                    </form>
                    <form method="POST" action="{{ route('admin.schools.reject', $school->id) }}" style="display:inline">
                        @csrf
                        <button type="submit">Weiger</button>
                    </form>
                </div>
            @empty
                <p>Geen nieuwe aanmeldingen.</p>
            @endforelse
        </div>

        <div class="blackLine"></div>

        <div class="tInfoContainer">
            <h2>Goedgekeurde scholen</h2>
        </div>
        <div class="infoContainer">

            @if(isset($schoolsAccepted) && $schoolsAccepted->count())
                @foreach($schoolsAccepted as $s)
                    <div class="userCard">
                        <h3>{{ $s->name }}</h3>
                        <p>Email: {{ $s->email }}</p>
                        <p>Type school: {{ $s->typeSchool }}</p>
                        <p>Address: {{ $s->address }}</p>

                        <form method="POST" action="{{ route('admin.schools.reject', $s->id) }}" style="display:inline">
                            @csrf
                            <button type="submit">Weiger</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>Geen goedgekeurde scholen.</p>
            @endif
        </div>

        <div class="blackLine"></div>


        <div class="tInfoContainer">
            <h2>Alle Accounts</h2>
        </div>

        <div class="infoContainer">
            @foreach ($users as $user)

                <div class="userCard">
                    <h3>User: {{ $user->name }}</h3>
                    <p>Email: {{ $user->email }}</p>

                    <p>Rol:
                        @if ($user->is_admin == 1)
                            Admin
                        @else
                            School
                        @endif
                    </p>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Bewerk</a>
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline" onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?');">
                        @csrf
                         @method('DELETE')
                        <button type="submit">Verwijder</button>
                    </form>



                

                </div>

            @endforeach
        </div>


        <div class="blackLine"></div>

        <div class="tInfoContainer">
            <h2>Account aanmaak</h2>
        </div>


        <div class="infoContainer">
            <form class="accountForm">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>

                <label for="role">Rol:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>

            </form>
        </div>

    </main>
</x-base-layout>