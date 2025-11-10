<x-base-layout>
    <main class="adminPage">
        <div class="tInfoContainer">
            <h2>Admin Panel</h2>
            <p>Hier kunt u wedstrijden beheren en aanmaken.</p>
        </div>
        <div class="butten">
            <a href="{{ url('/')}}">Maak wedstrijd</a>
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
            <h2>Alle Accounts</h2>
        </div>

        <div class="infoContainer">
            <div class="userCard">
                <h3>Gebruiker 1</h3>
                <p>Email:</p>
                <P>Rol:</P>
                <button>Bewerk</button>
                <button>Verwijder</button>

            </div>
            <div class="userCard">
                <h3>Gebruiker 2</h3>
                <p>Email:</p>
                <P>Rol:</P>
                <button>Bewerk</button>
                <button>Verwijder</button>

            </div>
            <div class="userCard">
                <h3>Gebruiker 3</h3>
                <p>Email:</p>
                <P>Rol:</P>
                <button>Bewerk</button>
                <button>Verwijder</button>

            </div>
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

                <button type="submit">Maak account aan</button>
            </form>

    </main>
</x-base-layout>