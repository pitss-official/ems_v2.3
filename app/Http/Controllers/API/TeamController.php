<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Team;
use App\Enrollment;
use App\User;
use function GuzzleHttp\Promise\exception_for;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{public function __construct()
{
    $this->middleware('auth:api');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'teamName' => 'required|min:5|unique:teams,name,eventID',
            'eventID' => 'bail|required|integer|min:0|exists:events,id',
            'description' => 'string|min:5',
    ]);

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
        $validatedData = $request->validate([
            'regNo'=> 'bail|required|numeric|digits:8|exists:enrollments,participantCollegeUID',
        ]);

        $currentUser = User::getCurrentAPIUser()['collegeUID'];
        if($currentUser == $validatedData['regNo'])
            throw new \Exception('user cant change his/her own team');
        else{
            return Team::getEventByCollegeUID($validatedData['regNo']);
        }
    }




    //todo: by anu changeTeam.vue
//    public function getTeam(Request $request ){
//        $validatedData = $request->validate([
//            'regNo'=> 'bail|required|integer|digits:8|exists:enrollable,participantCollegeUID',
//            'eventID'=> 'bail|required|min:1|integer|exists:events,id'
//        ]);
//
//        $currentUser = User::getCurrentAPIUser()['collegeUID'];
//        if($currentUser == $validatedData['regNo'])
//            throw new \Exception('user cant change his/her own team');
//
//        else{
//            return Enrollment::getCurrentTeam($validatedData['regNo'], $validatedData['eventID']);
//        }
//    }

    //todo: by anu changeTeam.vue
//    public function fetchTeamList(Request $request){
//        $validatedData = $request->validate([
//            'regNo'=> 'bail|required|integer|digits:8|exists:enrollments,participantCollegeUID',
//            'eventID'=> 'bail|required|min:1|integer|exists:events,id'
//        ]);
//
//        $currentUser = Auth::guard('api')->user()->collegeUID;
//        if($currentUser == $validatedData['regNo'])
//            throw new \Exception('user cant change his/her own team');
//
//        else{
//            return Team::getAllEnrollable($validatedData['eventID']);
//        }
//    }

    //todo: by anu for changeTeam.vue
    public function updateTeam(Request $request){
        $validatedData = $request->validate([
            'regNo'=> 'bail|required|integer|digits:8|exists:enrollments,participantCollegeUID',
            'enrollmentID'=> 'bail|required|integer|exists:enrollments,id',
            'newTeamID'=> 'bail|required|min:0|exists:teams,id',
        ]);
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
                        'error'=> 'Team caapcity is full',
                        'message'=>'cant add more members',
                    ];
                }

            }


        else{
            throw new \Exception("event does not support teams");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listAll($eventID)
    {
        return Event::findOrFail($eventID)->teams()->whereColumn('maxCapacity','>','availedCapacity')->get();
    }
}
