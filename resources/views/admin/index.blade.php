<x-base-layout>
    <main class="adminPage">



        <div class="tInfoContainer">
            <h2>Admin Panel</h2>
            <p>Hier kunt u wedstrijden beheren en aanmaken.</p>
        </div>
        <div class="butten">
            <a href="{{ route('tournaments.create') }}">Maak toernooi</a>
        </div>



        <div class="blackLine"></div>

        <div class="tInfoContainer">
            <h2>Ingeschreven scholen</h2>
        </div>

        <div class="statsContainer">
            <div class="counterBox">
                @if (count($schools) === 0)
                    <h4>Geen nieuwe aanmeldingen.</h4>
                @else
                    <h4>Aantal aanmeldingen:<span style="color: orange;"> {{ count($schools) }}
                        </span></h4>
                @endif
            </div>
        </div>


        <div class="infoContainer">
            @forelse($schools as $school)
                <div class="userCard">
                    <h3>{{ $school->name }}</h3>
                    <p>Email: {{ $school->email }}</p>
                    <p>Type school: {{ $school->typeSchool }}</p>
                    <p>Address: {{ $school->address }}</p>
                    <p>Telefoonnummer: {{ $school->phonenumber }}</p>
                    <form method="POST" action="{{ route('admin.schools.accept', $school->id) }}" style="display:inline"
                        class="accept-form">
                        @csrf
                        <button type="submit" class="accept-btn" data-cooldown="15000">Accepteer</button>
                    </form>

                    <form method="POST" action="{{ route('admin.schools.reject', $school->id) }}" style="display:inline">
                        @csrf
                        <button type="submit">Weiger</button>
                    </form>
                </div>
            @empty
            @endforelse
        </div>


        <div class="blackLine"></div>

        <div class="tInfoContainer">
            <h2>Goedgekeurde scholen</h2>
        </div>

        <div class="statsContainer">
            <div class="counterBox">
                @if (count($schoolsAccepted) === 0)
                    <h4>Geen Goedgekeurde scholen.</h4>
                @else
                    <h4>Aantal Goedgekeurde Scholen:<span style="color: #3e6a3e;"> {{ count($schoolsAccepted) }}
                        </span></h4>
                @endif
            </div>
        </div>


        <div class="infoContainer">

            @if (isset($schoolsAccepted) && $schoolsAccepted->count())
                @foreach ($schoolsAccepted as $s)
                    <div class="userCard">
                        <h3>{{ $s->name }}</h3>
                        <p>Email: {{ $s->email }}</p>
                        <p>Type school: {{ $s->typeSchool }}</p>
                        <p>Address: {{ $s->address }}</p>
                        <p>Telefoonnummer: {{ $s->phonenumber }}</p>

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
        <div class="statsContainer">
            <div class="counterBox">
                <p>Aantal Gebruikers: {{ $users->count() }}</p>
            </div>

            <div class="counterBox">
                <p>Aantal Admins: {{ $users->where('is_admin', 1)->count() }}</p>
            </div>

            <div class="counterBox">
                <p>Aantal Scholen: {{ $users->where('is_admin', 0)->count() }}</p>
            </div>
        </div>

        <div class="infoContainer">
            @foreach ($users as $user)
                <div class="userCard">

                    <h3>User: {{ $user->name }}</h3>
                    <p>Email: {{ $user->email }}</p>
                    <p>Telefoonnummer: {{ $user->school?->phone }}</p>


                    <p>Rol:
                        @if ($user->is_admin == 1)
                            Admin
                        @else
                            School
                        @endif
                    </p>

                    <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Bewerk</a>

                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline"
                        onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Verwijder</button>
                    </form>
                </div>
            @endforeach
        </div>



        <div class="blackLine"></div>


        <div class="tInfoContainer">
            <h2>Alle Teams</h2>
        </div>

        <div class="statsContainer">
            <div class="counterBox">
                <p>Aantal Teams {{ $teams->count() }}</p>
            </div>
        </div>

        <div class="infoContainer">
            @foreach ($teams as $team)
                <div class="userCard">
                    <h3>Team: {{ $team->name }}</h3>
                    <p>School: {{ $team->school->name }}</p>
                    <form method="POST" action="{{ route('team.destroy', $team->id) }}" style="display:inline"
                        onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Verwijder</button>
                    </form>





                </div>
            @endforeach
        </div>

        <div class="blackLine"></div>
        
        <div class="tInfoContainer">
            <h2>Alle Scheidsrechters</h2>
        </div>

        <div class="infoContainer">
            @foreach ($scheidsrechters as $scheidsrechter)
                <div class="userCard">
                    <h3>Scheidsrechter: {{ $scheidsrechter->name }}</h3>
                    <p>School: {{ $scheidsrechter->school ? $scheidsrechter->school->name : 'Geen school toegewezen' }}</p>
                    <h4>Email: {{ $scheidsrechter->email }}</h4>
                    <form method="POST" action="{{ route('scheidsrechters.destroy', $scheidsrechter->id) }}" style="display:inline"
                        onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?');">
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



            <section id="aanmaak"></section>
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

                <div class="form-group">
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Bevestig Wachtwoord:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <div class="form-group">
                        <label for="is_admin">Rol:</label>
                        <select id="is_admin" name="is_admin" required>
                            <option value="">-- Selecteer een rol --</option>
                            <option value="1">Admin</option>
                            <option value="0">School</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label for="school_id">School: (mag leeg blijven)</label>
                    <select id="school_id" name="school_id">
                        <option value="">-- Selecteer een school --</option>
                        <option value=""></option>
                        @foreach ($schools as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach

                    </select>
                </div>
                <button type="submit" class="btn-create-user">Maak Gebruiker aan</button>
            </form>
        </div>

        <div class="tInfoContainer">
            <h2>Sheidsrechter aanmaak</h2>
        </div>


        <div class="infoContainer">
            <form action="{{ route('scheidsrechters.store') }}" method="POST" class="create-user-form">
                @csrf
                <div class="form-group">
                    <label for="name">Naam:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="school_id">School:</label>
                    <select id="school_id" name="school_id" required>
                        <option value="">-- Selecteer een school --</option>
                        @foreach ($schoolsAccepted as $sa)
                            <option value="{{ $sa->id }}">{{ $sa->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-create-user">Maak Scheidsrechter aan</button>
            </form>
    </main>

    <script>
        //chagpt
        //dit zorgt ervoor dat de accepteer knop een cooldown krijgt van 15 seconden want als je snel meerdere,
        // scholen accepteerd dan wordt er geen mail gestuurd
        document.addEventListener('DOMContentLoaded', function () {
            const acceptForms = document.querySelectorAll('.accept-form');
            const cooldownMs = 15000;
            const storageKey = 'lastSchoolAcceptTime';

            function checkCooldown() {
                const lastSubmitTime = localStorage.getItem(storageKey);
                if (!lastSubmitTime) return 0;

                const now = Date.now();
                const timeSinceLastSubmit = now - parseInt(lastSubmitTime);
                return timeSinceLastSubmit < cooldownMs ? cooldownMs - timeSinceLastSubmit : 0;
            }

            function updateButtonStates() {
                const remainingMs = checkCooldown();
                acceptForms.forEach(form => {
                    const btn = form.querySelector('.accept-btn');
                    if (remainingMs > 0) {
                        btn.disabled = true;
                        const seconds = Math.ceil(remainingMs / 1000);
                        btn.textContent = `Wacht ${seconds}s...`;
                    } else {
                        btn.disabled = false;
                        btn.textContent = 'Accepteer';
                    }
                });
            }

            setInterval(updateButtonStates, 100);
            updateButtonStates();

            acceptForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const remainingMs = checkCooldown();
                    if (remainingMs > 0) {
                        e.preventDefault();
                        const remainingSeconds = Math.ceil(remainingMs / 1000);
                        alert(`Wacht alstublieft ${remainingSeconds} seconden voordat u een school accepteert.`);
                        return false;
                    }
                    localStorage.setItem(storageKey, Date.now().toString());
                    const submitBtn = form.querySelector('.accept-btn');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Verwerken...';
                    }
                });
            });
        });
    </script>
</x-base-layout>