<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\System;
use App\Team;
use App\Enrollment;
use App\User;
use function GuzzleHttp\Promise\exception_for;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(CreateTeamRequest $request)
    {
        $validatedData = $request->validatedAndSanitized();
        $coordinatorUID = Auth::guard('api')->user()->collegeUID;
        if(Team::isTeamable($validatedData['eventID'])) {
            if (Team::isNotExistByName($validatedData['teamName'])) {
                $team = new Team();
                $team->name = $validatedData['teamName'];
                $team->eventID = $validatedData['eventID'];
                $team->description = $validatedData['description'];
                $team->save();
                return $team->id;

            } else {
                return [
                    'error' => 'The team already exists',
                    'message' => 'Try another team name',
                ];
            }
        }
        else{
            throw new \Exception("event does not support teams");
        }
    }


    //todo: by anu changeTeam.vue
    public function getEventList(Request $request ){
        $validatedData = System::sanitize($request->validate([
            'regNo'=> 'bail|required|numeric|digits:8|exists:enrollments,participantCollegeUID',
        ]));

        $currentUser = User::getCurrentAPIUser()['collegeUID'];
        if($currentUser == $validatedData['regNo'])
            throw new \Exception('user cant change his/her own team');
        else{
            return Team::getEventByCollegeUID($validatedData['regNo']);
        }
    }

    //todo: by anu for changeTeam.vue
    public function updateTeam(UpdateTeamRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $e=Enrollment::findOrFail($validatedData['enrollmentID']);
        $n = Team::findOrFail($validatedData['newTeamID']);
        $oldTeamID = $e->teamID;
            if (Team::isNotExistByName($validatedData['newTeamID'])) {
                if($n->availedCapacity < $n->maxCapacity)
                {
                    return Team::updateTeamID($validatedData['regNo'],$validatedData['enrollmentID'],$validatedData['newTeamID'], $oldTeamID);

                }
                else{
                    return[
                        'error'=> 'Team capacity is full',
                        'message'=>'cant add more members',
                    ];
                }

            }
        else{
            throw new \Exception("event does not support teams");
        }
    }
    public function listAll(int $eventID)
    {
        return Event::findOrFail($eventID)->teams()->whereColumn('maxCapacity','>','availedCapacity')->get();
    }
}
