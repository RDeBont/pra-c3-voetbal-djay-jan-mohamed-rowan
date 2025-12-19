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
            ],
        ];

        $teams = Team::where('sport', $data['sport'])
            ->where('group', $data['group'])
            ->whereNull('tournament_id')
            ->get()
            ->shuffle();

        $teamsPerPool = $data['teamsPerPool'];
        $teamCount = $teams->count();

        if ($teamCount < $teamsPerPool || $teamCount % $teamsPerPool === 1) {
            return redirect()->back()->withErrors(['team' => 'Onjuiste teamverdeling.'])->withInput();
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

        $settings = $gameSettings[$data['sport']][$data['group']];

        $tournament = Tournament::create([
            'name' => $data['name'],
            'date' => $data['date'],
            'start_time' => $data['startTime'],
            'fields_amount' => $settings['fields'],
            'game_length_minutes' => $settings['length'],
            'amount_teams_pool' => $teamsPerPool,
            'archived' => false,
        ]);

        $teams = collect($poules)->flatten();
        foreach ($teams->values() as $i => $team) {
            $team->update([
                'pool' => floor($i / $teamsPerPool) + 1,
                'tournament_id' => $tournament->id,
            ]);
        }

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
        $slotLength = $settings['length'] + $settings['pause'];
        $busyTeams = [];
        $busyRefs = [];

        while (count($fixturesToCreate) > 0) {
            $scheduled = 0;
            $field = 1;

            for ($i = 0; $i < count($fixturesToCreate) && $field <= $settings['fields'];) {
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

                $ref = Scheidsrechter::where('school_id', '!=', $team1->school_id)
                    ->where('school_id', '!=', $team2->school_id)
                    ->get()
                    ->shuffle()
                    ->first(fn($r) => !isset($busyRefs[$r->id]) || !$busyRefs[$r->id]->gt($currentTime));

                if (!$ref) {
                    $i++;
                    continue;
                }

                $endTime = (clone $currentTime)->addMinutes($settings['length']);

                Fixture::create([
                    'team_1_id' => $team1->id,
                    'team_2_id' => $team2->id,
                    'team_1_score' => 0,
                    'team_2_score' => 0,
                    'field' => $field,
                    'start_time' => $currentTime->format('H:i'),
                    'end_time' => $endTime->format('H:i'),
                    'type' => 'pool',
                    'tournament_id' => $tournament->id,
                    'scheidsrechter_id' => $ref->id,
                    'round' => null,
                ]);

                $busyUntil = (clone $endTime)->addMinutes($settings['pause']);
                $busyTeams[$team1->id] = $busyUntil;
                $busyTeams[$team2->id] = $busyUntil;
                $busyRefs[$ref->id] = $busyUntil;

                array_splice($fixturesToCreate, $i, 1);
                $scheduled++;
                $field++;
            }

            $currentTime->addMinutes($slotLength);
        }

        return redirect()->route('admin.index')->with('success', 'Toernooi succesvol aangemaakt!');
    }

    public function show(Tournament $tournament)
    {
        $tournament->load(['fixtures.team1', 'fixtures.team2', 'fixtures.scheidsrechter']);
        return view('tournaments.show', compact('tournament'));
    }

    public function showKnockouts(Tournament $tournament)
    {
        $knockouts = Fixture::where('tournament_id', $tournament->id)
            ->where('type', 'knockout')
            ->with(['team1', 'team2', 'scheidsrechter'])
            ->orderByRaw("FIELD(round, 'Ronde 1', 'Kwartfinale', 'Halve Finale', 'Finale')")
            ->get();

        return view('tournaments.knockouts', compact('tournament', 'knockouts'));
    }

    public function generateKnockouts(Tournament $tournament)
    {
        if (Fixture::where('tournament_id', $tournament->id)->where('type', 'knockout')->exists()) {
            return redirect()->back()->with('info', 'Knockouts bestaan al.');
        }

        $teams = Team::where('tournament_id', $tournament->id)
            ->orderByDesc('poulePoints')
            ->get()
            ->groupBy('pool')
            ->flatMap(fn($g) => $g->take(2))
            ->shuffle()
            ->values();

        $round = $this->getRoundName($teams->count());

        for ($i = 0; $i < $teams->count(); $i += 2) {
            Fixture::create([
                'team_1_id' => $teams[$i]->id,
                'team_2_id' => $teams[$i + 1]->id,
                'team_1_score' => 0,
                'team_2_score' => 0,
                'field' => 1,
                'type' => 'knockout',
                'tournament_id' => $tournament->id,
                'round' => $round,
            ]);
        }

        return redirect()->back()->with('success', 'Knockouts aangemaakt!');
    }

    private function getRoundName($count)
    {
        return match ($count) {
            2 => 'Finale',
            4 => 'Halve Finale',
            8 => 'Kwartfinale',
            16 => 'Ronde 1',
            default => 'Ronde',
        };
    }

    private function getAllData()
    {
        return [
            'schools' => School::all(),
            'teams' => Team::all(),
            'users' => User::all(),
            'scheidsrechters' => Scheidsrechter::all(),
        ];
    }
}
