<x-base-layout>
    <section class="signupform-wrapper">
        <h2 class="ins">Team Aanmelden </h2>

        <form method="POST" action="" class="signupform">
            @csrf
            <!-- Mailadres Contactpersoon (Coach) -->
            <div class="signupform-group">
                <label for="coach_email">E-mailadres Contactpersoon (Coach)</label>
                <input type="email" name="coach_email" id="coach_email" class="signupform-control"
                    placeholder="Bijv. jan.devries@school.nl" required>
            </div>

            <div class="signupform-group">
                <label for="hoeveel_scheid">Aantal scheidsrechters beschikbaar</label>
                <select name="hoeveel_scheid" id="hoeveel_scheid" class="signupform-control" required>
                    <option value="">Selecteer aantal</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div id="scheidsrechters_container"></div>





            <div class="signupform-group">
                <label>Sport Type</label>

                <div>
                    <input type="checkbox" id="chk_lijnbal" value="lijnbal">
                    <label for="chk_lijnbal">Lijnbal</label>
                </div>

            </div>


            <div id="lijnbal" style="display: none;">
                <div class="signupform-control" style="margin-bottom: 10px;">

                    <input type="checkbox" id="chk_Lijnbal34" value="groep34">
                    <label for="chk_Lijnbal34">Groep 3/4 (Lijnbal)</label>

                    <div id="lijnbal34" style="display:none;">
                        <label>Aantal teams Groep 3/4</label>
                        <select id="aantal_lijnbal34" class="signupform-control">
                            <option value="">Selecteer aantal</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="lijnbal34_container"></div>
                    </div>
                </div>

                <div class="signupform-control" style="margin-bottom: 10px;">

                    <input type="checkbox" id="chk_Lijnbal56" value="groep56">
                    <label for="chk_Lijnbal56">Groep 5/6 (Lijnbal)</label>

                    <div id="lijnbal56" style="display:none;">
                        <label>Aantal teams Groep 5/6</label>
                        <select id="aantal_lijnbal56" class="signupform-control">
                            <option value="">Selecteer aantal</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="lijnbal56_container"></div>
                    </div>
                </div>
                <div class="signupform-control" style="margin-bottom: 10px;">

                    <input type="checkbox" id="chk_Lijnbal78" value="groep78">
                    <label for="chk_Lijnbal78">Groep 7/8 (Lijnbal)</label>

                    <div id="lijnbal78" style="display:none;">
                        <label>Aantal teams Groep 7/8</label>
                        <select id="aantal_lijnbal78" class="signupform-control">
                            <option value="">Selecteer aantal</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="lijnbal78_container"></div>
                    </div>
                </div>

            </div>


            <div class="signupform-group">
                <div>
                    <input type="checkbox" id="chk_voetbal" value="voetbal">
                    <label for="chk_voetbal">Voetbal</label>
                </div>
            </div>

            <div id="voetbal" style="display: none;">
                <div class="signupform-control" style="margin-bottom: 10px;">
                    <input type="checkbox" id="chk_Voetbal34" value="groep34">
                    <label for="chk_Voetbal34">Groep 3/4 (Voetbal)</label>

                    <div id="voetbal34" style="display:none;">
                        <label>Aantal teams Groep 3/4</label>
                        <select id="aantal_voetbal34" class="signupform-control">
                            <option value="">Selecteer aantal</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="voetbal34_container"></div>
                    </div>
                </div>
                <div class="signupform-control" style="margin-bottom: 10px;">

                    <input type="checkbox" id="chk_Voetbal56" value="groep56">
                    <label for="chk_Voetbal56">Groep 5/6 (Voetbal)</label>

                    <div id="voetbal56" style="display:none;">
                        <label>Aantal teams Groep 5/6</label>
                        <select id="aantal_voetbal56" class="signupform-control">
                            <option value="">Selecteer aantal</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="voetbal56_container"></div>
                    </div>
                </div>

                <div class="signupform-control" style="margin-bottom: 10px;">

                    <input type="checkbox" id="chk_Voetbal78" value="groep78">
                    <label for="chk_Voetbal78">Groep 7/8 (Voetbal)</label>

                    <div id="voetbal78" style="display:none;">
                        <label>Aantal teams Groep 7/8</label>
                        <select id="aantal_voetbal78" class="signupform-control">
                            <option value="">Selecteer aantal</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="voetbal78_container"></div>
                    </div>
                </div>

            </div>
            <!-- Submit -->
            <button type="submit" class="signupform-btn mt-3">Inschrijven</button>
        </form>
    </section>




</x-base-layout>
<script>

    document.getElementById("chk_lijnbal").addEventListener("change", function () {
        document.getElementById("lijnbal").style.display = this.checked ? "block" : "none";
    });

    document.getElementById("chk_voetbal").addEventListener("change", function () {
        document.getElementById("voetbal").style.display = this.checked ? "block" : "none";
    });
    // document.getElementById("chk_Groep34").addEventListener("change", function () {
    //     document.getElementById("groep34").style.display = this.checked ? "block" : "none";
    // });

    // Generate scheidsrechter email fields
    document.getElementById("hoeveel_scheid").addEventListener("change", function () {
        const aantal = parseInt(this.value);
        const container = document.getElementById("scheidsrechters_container");

        // Eerst alles leegmaken
        container.innerHTML = "";

        // Voor elk geselecteerd aantal een inputveld maken
        for (let i = 1; i <= aantal; i++) {
            const div = document.createElement("div");
            div.classList.add("signupform-group");

            div.innerHTML = `
            <label for="scheidsrechter_email_${i}">E-mailadres van Scheidsrechter ${i}</label>
            <input type="email"
                name="scheidsrechter_email_${i}"
                id="scheidsrechter_email_${i}"
                class="signupform-control"
                placeholder="Bijv. pietjanssen${i}@scheids.nl"
                required>
        `;

            container.appendChild(div);
        }
    });

    // document.getElementById("aantal_groepen34").addEventListener("change", function () {
    //     const aantal = parseInt(this.value);
    //     const container = document.getElementById("aantal_groepen34_container");

    //     // Eerst alles leegmaken
    //     container.innerHTML = "";

    //     // Voor elk geselecteerd aantal een inputveld maken
    //     for (let i = 1; i <= aantal; i++) {
    //         const div = document.createElement("div");
    //         div.classList.add("signupform-group");

    //         div.innerHTML = `
    //         <label for="teamName${i}">teamName ${i}</label>
    //         <input type="teamName"
    //             name="teamName${i}"
    //             id="teamName${i}"
    //             class="signupform-control"
    //             placeholder="Bijv. Team 1 college van Breda${i}"
    //             required>

    //         <input type="hidden" name="teamName[${i}][group]" value="groep34">

    //     `;

    //         container.appendChild(div);
    //     }
    // });
</script>

<script>

    function toggleSection(checkboxId, sectionId) {
        document.getElementById(checkboxId).addEventListener("change", function () {
            document.getElementById(sectionId).style.display = this.checked ? "block" : "none";
        });
    }

    // Lijnbal groepen toggles
    toggleSection("chk_Lijnbal34", "lijnbal34");
    toggleSection("chk_Lijnbal56", "lijnbal56");
    toggleSection("chk_Lijnbal78", "lijnbal78");

    // Voetbal groepen toggles
    toggleSection("chk_Voetbal34", "voetbal34");
    toggleSection("chk_Voetbal56", "voetbal56");
    toggleSection("chk_Voetbal78", "voetbal78");

    function generateTeams(selectId, containerId, sportType, groupName) {
        document.getElementById(selectId).addEventListener("change", function () {

            const aantal = parseInt(this.value);
            const container = document.getElementById(containerId);

            container.innerHTML = "";

            for (let i = 1; i <= aantal; i++) {
                const div = document.createElement("div");
                div.classList.add("signupform-group");

                div.innerHTML = `
                <label for="${sportType}_${groupName}_team${i}">Teamnaam ${i}</label>
                <input type="text"
                    id="${sportType}_${groupName}_team${i}"
                    name="teams[${sportType}][${groupName}][${i}][name]"
                    class="signupform-control"
                    placeholder="Team ${i}"
                    required>

                <input type="hidden" name="teams[${sportType}][${groupName}][${i}][sport]" value="${sportType}">
                <input type="hidden" name="teams[${sportType}][${groupName}][${i}][group]" value="${groupName}">
            `;

                container.appendChild(div);
            }
        });
    }

    // Lijnbal groepen
    generateTeams("aantal_lijnbal34", "lijnbal34_container", "lijnbal", "groep34");
    generateTeams("aantal_lijnbal56", "lijnbal56_container", "lijnbal", "groep56");
    generateTeams("aantal_lijnbal78", "lijnbal78_container", "lijnbal", "groep78");

    // Voetbal groepen
    generateTeams("aantal_voetbal34", "voetbal34_container", "voetbal", "groep34");
    generateTeams("aantal_voetbal56", "voetbal56_container", "voetbal", "groep56");
    generateTeams("aantal_voetbal78", "voetbal78_container", "voetbal", "groep78");

</script>