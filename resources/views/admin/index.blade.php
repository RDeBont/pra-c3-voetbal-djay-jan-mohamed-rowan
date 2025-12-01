<x-base-layout>
    <main class="adminPage">
        


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
        @if($errors->any())
            <div class="admin-message" style="background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb;">
                <ul style="list-style:none; padding:0; margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
       
        
    
          <form action="{{ route('users.store') }}" method="POST" class="create-user-form">
            @csrf
            <div class="form-group">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group>
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Bevestig Wachtwoord:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            <div class="form-group">
                <label for="is_admin">Rol:</label>
                <select id="is_admin" name="is_admin" required>
                    <option value="1">Admin</option>
                    <option value="0">School</option>
                </select>
            </div>
        </div>

            <button type="submit" class="btn-create-user">Maak Gebruiker aan</button>
          </form>

    </main>
</x-base-layout>