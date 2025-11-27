<x-base-layout>
    <section class="signupform-wrapper">
        <h2 class="ins">Team Aanmelden</h2>
        <h2>School: {{ $school->name }}</h2>

        <p><strong>Lijnbal:</strong> alleen voor meiden</p>
        <p><strong>Voetbal:</strong> voor jongens en meiden</p>

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
                $isMiddelbare = $school->type === 'middelbare';
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
                    <!-- Middelbare school: alleen Klas1 -->
                    <div class="signupform-control">
                        <input type="checkbox" id="chk_LijnbalKlas1" value="klas1">
                        <label for="chk_LijnbalKlas1">Klas 1 (Lijnbal)</label>
                        <div id="lijnbalKlas1" style="display:none;">
                            <label>Aantal teams Klas 1</label>
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
                    <!-- Basisschool: groepen 3/4, 5/6, 7/8 -->
                    @foreach(['3/4', '5/6', '7/8'] as $groep)
                        <div class="signupform-control" style="margin-bottom: 10px;">
                            <input type="checkbox" id="chk_Lijnbal{{ $groep }}" value="groep{{ $groep }}">
                            <label for="chk_Lijnbal{{ $groep }}">Groep {{ $groep }} (Lijnbal)</label>
                            <div id="lijnbal{{ $groep }}" style="display:none;">
                                <label>Aantal teams Groep {{ $groep }}</label>
                                <select id="aantal_lijnbal{{ $groep }}" class="signupform-control">
                                    <option value="">Selecteer aantal</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div id="lijnbal{{ $groep }}_container"></div>
                            </div>
                        </div>
                    @endforeach
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
                    <!-- Middelbare school: Klas1 -->
                    <div class="signupform-control">
                        <input type="checkbox" id="chk_VoetbalKlas1" value="klas1">
                        <label for="chk_VoetbalKlas1">Klas 1 (Voetbal)</label>
                        <div id="voetbalKlas1" style="display:none;">
                            <label>Aantal teams Klas 1</label>
                            <select id="aantal_voetbalKlas1" class="signupform-control">
                                <option value="">Selecteer aantal</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <div id="voetbalKlas1_container"></div>
                        </div>
                    </div>
                @else
                    <!-- Basisschool: groepen 3/4, 5/6, 7/8 -->
                    @foreach(['3/4', '5/6', '7/8'] as $groep)
                        <div class="signupform-control" style="margin-bottom: 10px;">
                            <input type="checkbox" id="chk_Voetbal{{ $groep }}" value="groep{{ $groep }}">
                            <label for="chk_Voetbal{{ $groep }}">Groep {{ $groep }} (Voetbal)</label>
                            <div id="voetbal{{ $groep }}" style="display:none;">
                                <label>Aantal teams Groep {{ $groep }}</label>
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
        function generateTeams(selectId, containerId, sportType, groupName) {
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
            toggleSection("chk_Lijnbal" + groep, "lijnbal" + groep);
            toggleSection("chk_Voetbal" + groep, "voetbal" + groep);

            generateTeams("aantal_lijnbal" + groep, "lijnbal" + groep + "_container", "lijnbal", "groep" + groep);
            generateTeams("aantal_voetbal" + groep, "voetbal" + groep + "_container", "voetbal", "groep" + groep);
        });

        // Middelbare school Klas1 toggles
        toggleSection("chk_LijnbalKlas1", "lijnbalKlas1");
        toggleSection("chk_VoetbalKlas1", "voetbalKlas1");

        generateTeams("aantal_lijnbalKlas1", "lijnbalKlas1_container", "lijnbal", "klas1");
        generateTeams("aantal_voetbalKlas1", "voetbalKlas1_container", "voetbal", "klas1");

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
                `;
                container.appendChild(div);
            }
        });
    </script>
</x-base-layout>