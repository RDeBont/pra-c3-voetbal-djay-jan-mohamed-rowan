<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Scheidsrechter;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all();
        return view('tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        $all = $this->getAllData();
        return view('tournaments.createTournament', compact('all'));
    }

    public function store(StoreTournamentRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'sport' => 'required|in:voetbal,lijnbal',
            'group' => 'required|in:groep3/4,groep5/6,groep7/8,klas1_jongens,klas1_meiden',
            'startTime' => 'required|date_format:H:i',
            'teamsPerPool' => 'required|integer|min:2',
            'qualified_per_pool' => 'required|integer|min:1',
        ]);

        if (Tournament::where('name', $data['name'])->exists()) {
            return redirect()->back()->withErrors(['name' => 'Er bestaat al een toernooi met deze naam.'])->withInput();
        }

        $gameSettings = [
            'voetbal' => [
                'groep3/4' => ['fields' => 4, 'length' => 15, 'pause' => 5],
                'groep5/6' => ['fields' => 8, 'length' => 15, 'pause' => 5],
                'groep7/8' => ['fields' => 8, 'length' => 15, 'pause' => 5],
                'klas1_meiden' => ['fields' => 4, 'length' => 15, 'pause' => 5],
                'klas1_jongens' => ['fields' => 3, 'length' => 15, 'pause' => 5],
            ],
            'lijnbal' => [
                'groep3/4' => ['fields' => 4, 'length' => 10, 'pause' => 2],
                'groep5/6' => ['fields' => 4, 'length' => 10, 'pause' => 2],
                'groep7/8' => ['fields' => 4, 'length' => 10, 'pause' => 2],
                'klas1_meiden' => ['fields' => 4, 'length' => 12, 'pause' => 0],
                'klas1_jongens' => ['fields' => 4, 'length' => 12, 'pause' => 0],
            ]
        ];

        $teams = Team::where('sport', $data['sport'])
            ->where('group', $data['group'])
            ->whereNull('tournament_id')
            ->get()
            ->shuffle();

        $teamsPerPool = $data['teamsPerPool'];
        $teamCount = $teams->count();

        if ($teamCount < $teamsPerPool) {
            return redirect()->back()->withErrors(['team' => 'Niet genoeg teams beschikbaar.'])->withInput();
        }

        if ($teamCount % $teamsPerPool === 1) {
            return redirect()->back()->withErrors(['team' => 'Er blijft 1 team over dat alleen in een poule zou zitten.'])->withInput();
        }

        $teamsBySchool = $teams->groupBy('school_id');
        $pouleCount = (int) ceil($teamCount / $teamsPerPool);
        $poules = array_fill(0, $pouleCount, []);

        $index = 0;
        foreach ($teamsBySchool as $schoolTeams) {
            if ($schoolTeams->count() > $pouleCount) {
                return redirect()->back()->withErrors(['team' => 'Te veel teams van dezelfde school.'])->withInput();
            }

            foreach ($schoolTeams as $team) {
                $poules[$index % $pouleCount][] = $team;
                $index++;
            }
        }

        $fields = $gameSettings[$data['sport']][$data['group']]['fields'];

        $tournament = Tournament::create([
            'name' => $data['name'],
            'date' => $data['date'],
            'start_time' => $data['startTime'],
            'fields_amount' => $fields,
            'game_length_minutes' => $gameSettings[$data['sport']][$data['group']]['length'],
            'amount_teams_pool' => $teamsPerPool,
            'qualified_per_pool' => $data['qualified_per_pool'],
            'archived' => false,
        ]);

        $teams = collect($poules)->flatten();
        foreach ($teams->values() as $i => $team) {
            $team->update([
                'pool' => floor($i / $teamsPerPool) + 1,
                'tournament_id' => $tournament->id,
            ]);
        }

        /* ---------------- POOL WEDSTRIJDEN PLANNEN ---------------- */

        $teamsByPool = $teams->groupBy('pool');
        $fixturesToCreate = [];

        foreach ($teamsByPool as $poolTeams) {
            $poolTeams = $poolTeams->values();
            for ($i = 0; $i < $poolTeams->count(); $i++) {
                for ($j = $i + 1; $j < $poolTeams->count(); $j++) {
                    $fixturesToCreate[] = [
                        'team1' => $poolTeams[$i],
                        'team2' => $poolTeams[$j],
                    ];
                }
            }
        }

        $currentTime = Carbon::createFromFormat('H:i', $data['startTime']);
        $gameLength = $gameSettings[$data['sport']][$data['group']]['length'];
        $pause = $gameSettings[$data['sport']][$data['group']]['pause'];
        $slotLength = $gameLength + $pause;

        $busyTeams = [];
        $busyRefs = [];

        while (count($fixturesToCreate) > 0) {
            $scheduledThisSlot = 0;
            $fieldNumber = 1;

            for ($i = 0; $i < count($fixturesToCreate) && $fieldNumber <= $fields;) {
                $fixture = $fixturesToCreate[$i];
                $team1 = $fixture['team1'];
                $team2 = $fixture['team2'];

                if (
                    (isset($busyTeams[$team1->id]) && $busyTeams[$team1->id]->gt($currentTime)) ||
                    (isset($busyTeams[$team2->id]) && $busyTeams[$team2->id]->gt($currentTime))
                ) {
                    $i++;
                    continue;
                }

                $refCandidates = Scheidsrechter::where('school_id', '!=', $team1->school_id)
                    ->where('school_id', '!=', $team2->school_id)
                    ->get()
                    ->shuffle();

                $ref = $refCandidates->first(fn($r) =>
                    !isset($busyRefs[$r->id]) || !$busyRefs[$r->id]->gt($currentTime)
                );

                if (!$ref) {
                    $i++;
                    continue;
                }

                $endTime = (clone $currentTime)->addMinutes($gameLength);

                Fixture::create([
                    'team_1_id' => $team1->id,
                    'team_2_id' => $team2->id,
                    'team_1_score' => 0,
                    'team_2_score' => 0,
                    'field' => $fieldNumber,
                    'start_time' => $currentTime->format('H:i'),
                    'end_time' => $endTime->format('H:i'),
                    'type' => 'pool',
                    'tournament_id' => $tournament->id,
                    'scheidsrechter_id' => $ref->id,
                    'round' => null,
                ]);

                $busyUntil = (clone $endTime)->addMinutes($pause);
                $busyTeams[$team1->id] = $busyUntil;
                $busyTeams[$team2->id] = $busyUntil;
                $busyRefs[$ref->id] = $busyUntil;

                array_splice($fixturesToCreate, $i, 1);
                $scheduledThisSlot++;
                $fieldNumber++;
            }

            if ($scheduledThisSlot === 0) {
                $earliest = null;

                foreach ($fixturesToCreate as $fixture) {
                    foreach ([$fixture['team1']->id, $fixture['team2']->id] as $tid) {
                        if (isset($busyTeams[$tid]) && $busyTeams[$tid]->gt($currentTime)) {
                            if ($earliest === null || $busyTeams[$tid]->lt($earliest)) {
                                $earliest = $busyTeams[$tid];
                            }
                        }
                    }
                }

                foreach ($busyRefs as $refBusyUntil) {
                    if ($refBusyUntil->gt($currentTime)) {
                        if ($earliest === null || $refBusyUntil->lt($earliest)) {
                            $earliest = $refBusyUntil;
                        }
                    }
                }

                $currentTime = $earliest?->copy() ?? $currentTime->addMinutes($slotLength);
            } else {
                $currentTime->addMinutes($slotLength);
            }
        }

        return redirect()->route('admin.index')->with('success', 'Toernooi succesvol aangemaakt!');
    }

    public function show(Tournament $tournament)
    {
        $fixtures = Fixture::where('tournament_id', $tournament->id)
            ->with(['team1', 'team2', 'scheidsrechter'])
            ->orderBy('start_time')
            ->get();

        return view('tournaments.show', compact('tournament', 'fixtures'));
    }

    /* ---------------- KNOCKOUTS ---------------- */

    public function showKnockouts(Tournament $tournament)
    {
        $knockouts = Fixture::where('tournament_id', $tournament->id)
            ->where('type', 'knockout')
            ->with(['team1', 'team2', 'scheidsrechter'])
            ->orderByRaw("FIELD(round, 'Ronde 1', 'Kwartfinale', 'Halve Finale', 'Finale')")
            ->get();

        return view('tournaments.knockouts', compact('tournament', 'knockouts'));
    }

    public function showKnockoutsPublic(Tournament $tournament)
    {
        $this->fillNextKnockoutRound($tournament);

        $knockouts = Fixture::where('tournament_id', $tournament->id)
            ->where('type', 'knockout')
            ->with(['team1', 'team2', 'scheidsrechter'])
            ->orderByRaw("FIELD(round, 'Ronde 1', 'Kwartfinale', 'Halve Finale', 'Finale')")
            ->get();

        return view('tournaments.knockouts_public', compact('tournament', 'knockouts'));
    }

    private function fillNextKnockoutRound(Tournament $tournament)
    {
        $rounds = Fixture::where('tournament_id', $tournament->id)
            ->where('type', 'knockout')
            ->get()
            ->groupBy('round');

        foreach ($rounds as $roundName => $fixtures) {
            $emptyFixtures = $fixtures->filter(fn($f) => !$f->team_1_id || !$f->team_2_id);
            if ($emptyFixtures->isEmpty()) continue;

            $prevRound = $this->getPreviousRound($roundName);
            if (!$prevRound || !isset($rounds[$prevRound])) continue;

            $winners = $rounds[$prevRound]->map(function ($f) {
                if ($f->team_1_score > $f->team_2_score) return $f->team_1_id;
                if ($f->team_2_score > $f->team_1_score) return $f->team_2_id;
                return null;
            })->filter()->values();

            foreach ($emptyFixtures as $i => $fixture) {
                if (isset($winners[$i*2])) $fixture->update(['team_1_id' => $winners[$i*2]]);
                if (isset($winners[$i*2+1])) $fixture->update(['team_2_id' => $winners[$i*2+1]]);
            }
        }
    }

    private function getPreviousRound($roundName)
    {
        return match ($roundName) {
            'Finale' => 'Halve Finale',
            'Halve Finale' => 'Kwartfinale',
            'Kwartfinale' => 'Ronde 1',
            default => null,
        };
    }

    public function generateKnockouts(Tournament $tournament)
    {
        if (Fixture::where('tournament_id', $tournament->id)->where('type', 'knockout')->exists()) {
            return redirect()->back()->with('info', 'Knockouts zijn al gegenereerd.');
        }

        $qualifiedPerPool = $tournament->qualified_per_pool;

        $teamsByPool = Team::where('tournament_id', $tournament->id)
            ->orderByDesc('poulePoints')
            ->get()
            ->groupBy('pool');

        $qualifiedTeams = collect();
        foreach ($teamsByPool as $teams) {
            $qualifiedTeams = $qualifiedTeams->concat($teams->take($qualifiedPerPool));
        }

        $qualifiedTeams = $qualifiedTeams->shuffle()->values();
        $desiredCount = pow(2, floor(log($qualifiedTeams->count(), 2)));
        $qualifiedTeams = $qualifiedTeams->take($desiredCount)->values();

        $this->createKnockoutBracket($tournament, $qualifiedTeams);

        return redirect()->back()->with('success', 'Volledige knockout-bracket aangemaakt!');
    }

    private function createKnockoutBracket(Tournament $tournament, $teams)
    {
        $rounds = [
            16 => 'Ronde 1',
            8  => 'Kwartfinale',
            4  => 'Halve Finale',
            2  => 'Finale',
        ];

        $currentTeams = $teams;

        while ($currentTeams->count() >= 2) {
            $roundName = $rounds[$currentTeams->count()] ?? 'Ronde';

            for ($i = 0; $i < $currentTeams->count(); $i += 2) {
                if (isset($currentTeams[$i + 1])) {
                    Fixture::create([
                        'team_1_id' => $currentTeams[$i]->id,
                        'team_2_id' => $currentTeams[$i + 1]->id,
                        'team_1_score' => 0,
                        'team_2_score' => 0,
                        'field' => 1,
                        'type' => 'knockout',
                        'tournament_id' => $tournament->id,
                        'round' => $roundName,
                    ]);
                }
            }

            $currentTeams = collect(array_fill(0, $currentTeams->count() / 2, null));
        }
    }

    public function advanceKnockoutRound(Tournament $tournament)
    {
        $rounds = Fixture::where('tournament_id', $tournament->id)
            ->where('type', 'knockout')
            ->get()
            ->groupBy('round');

        $lastRoundFixtures = $rounds->last();

        if ($lastRoundFixtures->contains(fn($f) => $f->team_1_score === 0 && $f->team_2_score === 0)) {
            return redirect()->back()->with('info', 'Niet alle wedstrijden zijn afgerond.');
        }

        $winners = $lastRoundFixtures->map(function ($fixture) {
            return $fixture->team_1_score > $fixture->team_2_score
                ? $fixture->team_1_id
                : $fixture->team_2_id;
        })->values();

        $roundName = $this->getRoundName($winners->count());

        for ($i = 0; $i < $winners->count(); $i += 2) {
            if (isset($winners[$i + 1])) {
                Fixture::create([
                    'team_1_id' => $winners[$i],
                    'team_2_id' => $winners[$i + 1],
                    'team_1_score' => 0,
                    'team_2_score' => 0,
                    'field' => 1,
                    'type' => 'knockout',
                    'tournament_id' => $tournament->id,
                    'round' => $roundName,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Winnaars doorgestroomd!');
    }

    private function getRoundName($teamCount)
    {
        return match ($teamCount) {
            2 => 'Finale',
            4 => 'Halve Finale',
            8 => 'Kwartfinale',
            16 => 'Ronde 1',
            default => 'Ronde',
        };
    }

    public function getAllData()
    {
        return [
            'schools' => School::all(),
            'teams' => Team::all(),
            'users' => User::all(),
            'scheidsrechters' => Scheidsrechter::all(),
        ];
    }

    public function standings(Tournament $tournament)
    {
        $teams = Team::where('tournament_id', $tournament->id)
            ->orderByDesc('poulePoints')
            ->orderByDesc('pouleGoals')
            ->get();

        $stand = $teams->groupBy('pool')->sortKeys();
        return view('tournaments.standings', compact('tournament', 'teams', 'stand'));
    }
}
