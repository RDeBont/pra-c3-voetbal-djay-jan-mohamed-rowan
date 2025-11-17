<x-base-layout>
    <div class="container">
        <div class="tInfoContainer">
            <h1>Wedstrijden aanmaken</h1>
        </div>
                <div class="blackLine"></div>


        <div class="formTournament">
            <form method="POST" action="{{ route('admin.store') }}">
                @csrf

                <div class="formGroup">
                    <label for="name">Toernooi naam</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="formGroup">
                    <label for="date">Datum</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="formGroup">
                    <label for="type">Type</label>
                    <select id="type" name="type">
                        <option value="voetbal">Voetbal</option>
                        <option value="lijnbal">Lijnbal</option>
                        <option value="ander">Anders</option>
                    </select>
                </div>

                <div class="formGroup">
                    <label for="fields_amount">Aantal velden</label>
                    <input type="number" id="fields_amount" name="fields_amount" min="1" value="1">
                </div>

                <div class="formGroup">
                    <label for="game_length_minutes">Speelduur (minuten)</label>
                    <input type="number" id="game_length_minutes" name="game_length_minutes" min="1" value="10">
                </div>

                <div class="formGroup">
                    <label for="amount_teams_pool">Teams per poule</label>
                    <input type="number" id="amount_teams_pool" name="amount_teams_pool" min="1" value="4">
                </div>

                <div class="formGroup">
                    <label for="archived">Gearchiveerd</label>
                    <select id="archived" name="archived">
                        <option value="0">Nee</option>
                        <option value="1">Ja</option>
                    </select>
                </div>

                <div class="formGroup">
                    <button type="submit" class="btnLogin">Maak schema aan</button>
                </div>

            </form>
        </div>
    </div>
</x-base-layout>