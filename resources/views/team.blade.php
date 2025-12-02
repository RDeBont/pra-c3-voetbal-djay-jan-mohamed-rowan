<x-base-layout>
    <section class="signupform-wrapper">
        <h2 class="ins">Team Aanmelden</h2>
        <h2>School: {{ $school->name }}</h2>


        <form method="POST" action="{{ route('team.store') }}" class="signupform">
            @csrf

            <div class="signupform-group">
                <label for="hoeveel_scheid">Aantal scheidsrechters beschikbaar</label>
                <select name="hoeveel_scheid" id="hoeveel_scheid" class="signupform-control" required>
                    <option value="">Selecteer aantal</option>
                    @for($i = 0; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div id="scheidsrechters_container"></div>

            @php
                $isMiddelbare = trim(strtolower($school->typeSchool)) === 'middelbare school';
            @endphp


            <!-- Lijnbal -->    
            <div class="signupform-group">
                <div class="signupform-control">
                    <label for="chk_lijnbal">Lijnbal</label>
                    <input type="checkbox" id="chk_lijnbal" value="lijnbal">
                </div>
            </div>

            <div id="lijnbal" style="display: none;">

                @if($isMiddelbare)
                    <!-- Lijnbal 1e klas (meiden) -->
                    <div class="signupform-control">
                        <input type="checkbox" id="chk_LijnbalKlas1" value="klas1_meiden">
                        <label for="chk_LijnbalKlas1">1e klas (meiden) – Lijnbal</label>

                        <div id="lijnbalKlas1" style="display:none;">
                            <label>Aantal teams 1e klas (meiden)</label>
                            <select id="aantal_lijnbalKlas1" class="signupform-control">
                                <option value="">Selecteer aantal</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <div id="lijnbalKlas1_container"></div>
                        </div>
                    </div>

                @else
                    <!-- Basisschool: alleen groep 7/8 (meiden) -->
                    @php $groep = "7/8"; @endphp

                    <div class="signupform-control">
                        <input type="checkbox" id="chk_Lijnbal{{ $groep }}" value="groep{{ $groep }}_meiden">
                        <label for="chk_Lijnbal{{ $groep }}">Groep {{ $groep }} (meiden) – Lijnbal</label>

                        <div id="lijnbal{{ $groep }}" style="display:none;">
                            <label>Aantal teams Groep {{ $groep }} (meiden)</label>
                            <select id="aantal_lijnbal{{ $groep }}" class="signupform-control">
                                <option value="">Selecteer aantal</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <div id="lijnbal{{ $groep }}_container"></div>
                        </div>
                    </div>

                @endif
            </div>


            <!-- Voetbal -->
            <div class="signupform-group">
                <div class="signupform-control">
                    <label for="chk_voetbal">Voetbal</label>
                    <input type="checkbox" id="chk_voetbal" value="voetbal">
                </div>
            </div>

            <div id="voetbal" style="display: none;">

                @if($isMiddelbare)
                    <!-- VOETBAL 1e klas jongens/gemengd -->
                    <div class="signupform-control">
                        <input type="checkbox" id="chk_VoetbalKlas1J" value="klas1_jongens">
                        <label for="chk_VoetbalKlas1J">1e klas (jongens/gemengd) – Voetbal</label>

                        <div id="voetbalKlas1J" style="display:none;">
                            <label>Aantal teams 1e klas (jongens/gemengd)</label>
                            <select id="aantal_voetbalKlas1J" class="signupform-control">
                                <option value="">Selecteer aantal</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <div id="voetbalKlas1J_container"></div>
                        </div>
                    </div>

                    <!-- VOETBAL 1e klas meiden -->
                    <div class="signupform-control">
                        <input type="checkbox" id="chk_VoetbalKlas1M" value="klas1_meiden">
                        <label for="chk_VoetbalKlas1M">1e klas (meiden) – Voetbal</label>

                        <div id="voetbalKlas1M" style="display:none;">
                            <label>Aantal teams 1e klas (meiden)</label>
                            <select id="aantal_voetbalKlas1M" class="signupform-control">
                                <option value="">Selecteer aantal</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <div id="voetbalKlas1M_container"></div>
                        </div>
                    </div>

                @else
                    <!-- Basisschool: alle groepen gemengd -->
                    @foreach(['3/4', '5/6', '7/8'] as $groep)
                        <div class="signupform-control">
                            <input type="checkbox" id="chk_Voetbal{{ $groep }}" value="groep{{ $groep }}_gemengd">
                            <label for="chk_Voetbal{{ $groep }}">Groep {{ $groep }} (gemengd) – Voetbal</label>

                            <div id="voetbal{{ $groep }}" style="display:none;, ">
                                <label>Aantal teams Groep {{ $groep }} (gemengd)</label>
                                <select id="aantal_voetbal{{ $groep }}" class="signupform-control">
                                    <option value="">Selecteer aantal</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div id="voetbal{{ $groep }}_container"></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>


            <button type="submit" class="signupform-btn mt-3">Inschrijven</button>
        </form>
    </section>

    <script>
        // Toggle functie
        function toggleSection(checkboxId, sectionId) {
            const checkbox = document.getElementById(checkboxId);
            if (checkbox) {
                checkbox.addEventListener("change", function () {
                    document.getElementById(sectionId).style.display = this.checked ? "block" : "none";
                });
            }
        }

        // Generate inputvelden voor teamnamen
        function generateTeams(selectId, containerId, sportType, groupName, teamsort) {
            const select = document.getElementById(selectId);
            if (select) {
                select.addEventListener("change", function () {
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

                    <input type="hidden" name="teams[${sportType}][${groupName}][${i}][teamsort]" value="${teamsort}">
                    <input type="hidden" name="teams[${sportType}][${groupName}][${i}][sport]" value="${sportType}">
                    <input type="hidden" name="teams[${sportType}][${groupName}][${i}][group]" value="${groupName}">
                    <input type="hidden" name="teams[${sportType}][${groupName}][${i}][school_id]" value="{{ $school->id }}">
                `;
                        container.appendChild(div);
                    }
                });
            }
        }

        // Hoofd toggles voor sporttype
        toggleSection("chk_lijnbal", "lijnbal");
        toggleSection("chk_voetbal", "voetbal");

        // Basisschool groepen toggles
        ["3/4", "5/6", "7/8"].forEach(function (groep) {
            toggleSection("chk_Voetbal" + groep, "voetbal" + groep);
            generateTeams(
                "aantal_voetbal" + groep,
                "voetbal" + groep + "_container",
                "voetbal",
                "groep" + groep,
                "gemengd"
            );
        });

        ["7/8"].forEach(function (groep) {
            toggleSection("chk_Lijnbal" + groep, "lijnbal" + groep);
            generateTeams(
                "aantal_lijnbal" + groep,
                "lijnbal" + groep + "_container",
                "lijnbal",
                "groep" + groep,
                "meiden"
            );
        });

        toggleSection("chk_VoetbalKlas1J", "voetbalKlas1J");
        generateTeams(
            "aantal_voetbalKlas1J",
            "voetbalKlas1J_container",
            "voetbal",
            "klas1_jongens",
            "jongens/gemengd"
        );

        toggleSection("chk_VoetbalKlas1M", "voetbalKlas1M");
        generateTeams(
            "aantal_voetbalKlas1M",
            "voetbalKlas1M_container",
            "voetbal",
            "klas1_meiden",
            "meiden"
        );

        toggleSection("chk_LijnbalKlas1", "lijnbalKlas1");
        generateTeams(
            "aantal_lijnbalKlas1",
            "lijnbalKlas1_container",
            "lijnbal",
            "klas1_meiden",
            "meiden"
        );

        // Scheidsrechters dynamisch
        document.getElementById("hoeveel_scheid").addEventListener("change", function () {
            const aantal = parseInt(this.value);
            const container = document.getElementById("scheidsrechters_container");
            container.innerHTML = "";

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
                    <label for="scheidsrechter_name_${i}">Naam van Scheidsrechter ${i} (optioneel)</label>
                    <input type="text"
                        name="scheidsrechter_name_${i}"
                        id="scheidsrechter_name_${i}"
                        class="signupform-control"
                        placeholder="Bijv. Piet Janssen"
                        required>

                `;
                container.appendChild(div);
            }
        });
    </script>
</x-base-layout>