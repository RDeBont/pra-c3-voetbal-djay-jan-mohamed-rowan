<x-base-layout>

    <section class="signupform-wrapper">
                <div class="top-buttons">
            <a class="btn-goback" href="/admin">Ga Terug</a>
        </div>
        <h2 class="ins">Nieuw Toernooi Aanmaken</h2>




        <form method="POST" action="{{ route('tournaments.store') }}" class="signupform">
            @csrf


            <div class="signupform-group">
                <label for="name">Toernooinaam:</label>
                <input type="text" name="name" id="name" class="signupform-control" required>
            </div>
            <div class="signupform-group">
                <label for="date">Datum Toernooi:</label>
                <input type="date" name="date" id="date" class="signupform-control" required>
            </div>

            <div class="signupform-group">
                <label for="startTime">Startijd:</label>
                <input type="text" id="startTime" name="startTime" class="signupform-control" required>
            </div>

            <div class="signupform-group">
                <label for="teamsPerPool">Aantal teams per poule:</label>
                <input type="number" name="teamsPerPool" id="teamsPerPool" class="signupform-control" min="2" required>
            </div>

            <div class="signupform-group">
                <label for="school_level">Schoolniveau:</label>
                <select name="school_level" id="school_level" class="signupform-control" required>
                    <option value="">-- Kies niveau --</option>
                    <option value="basisschool">Basisschool</option>
                    <option value="middelbare">Middelbare school</option>
                </select>
            </div>


            <div class="signupform-group">
                <label for="sport">Soort sport:</label>
                <select name="sport" id="sport" class="signupform-control" required>
                    <option value="">-- Kies sport --</option>
                    <option value="voetbal">Voetbal</option>
                    <option value="lijnbal">Lijnbal</option>
                </select>
            </div>


            <div class="signupform-group">
                <label for="group">Groep:</label>

                <select name="group" id="group" class="signupform-control" required>
                    <option value="">-- Kies eerst schoolniveau --</option>
                </select>
            </div>


            <button type="submit" class="signupform-btn mt-3">Maak Toernooi</button>


        </form>
    </section>



    <script>
        flatpickr("#startTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        })
        //Chatgpt
        const groupSelect = document.getElementById('group');
        const schoolLevelSelect = document.getElementById('school_level');
        const sportSelect = document.getElementById('sport');

        const options = {
            basisschool: {
                voetbal: [
                    { value: "groep3/4", label: "Groep 3/4 (gemengd)" },
                    { value: "groep5/6", label: "Groep 5/6 (gemengd)" },
                    { value: "groep7/8", label: "Groep 7/8 (gemengd)" }
                ],
                lijnbal: [
                    { value: "groep7/8", label: "Groep 7/8 Lijnbal Meiden" }
                ]
            },
            middelbare: {
                voetbal: [
                    { value: "klas1_jongens", label: "1e klas Jongens/Gemengd" },
                    { value: "klas1_meiden", label: "1e klas Meiden" }
                ],
                lijnbal: [
                    { value: "klas1_meiden", label: "1e klas Lijnbal Meiden" }
                ]
            }
        };

        function updateGroupOptions() {
            const level = schoolLevelSelect.value;
            const sport = sportSelect.value;

            groupSelect.innerHTML = `<option value="">-- Kies groep --</option>`;

            if (level && sport && options[level][sport]) {
                options[level][sport].forEach(opt => {
                    groupSelect.innerHTML += `<option value="${opt.value}">${opt.label}</option>`;
                });
            }
        }

        schoolLevelSelect.addEventListener("change", updateGroupOptions);
        sportSelect.addEventListener("change", updateGroupOptions);
    </script>
</x-base-layout>
