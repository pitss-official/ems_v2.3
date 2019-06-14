<?php

namespace App;

use App\Exceptions\TeamException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class Team extends Model
{
    //
    protected $visible = ['name', 'id'];


    public static function isNotExist($id)
    {
        return !self::isExist($id);
    }

    public static function isNotExistByName($name)
    {
        return !self::isExistByName($name);
    }

    public static function isExist($id)
    {
        if (Team::where('id', $id)->count() == 1)
            return true;
        else return false;
    }

    public static function isExistByName($name)
    {
        if (Team::where('name', $name)->count() == 1)
            return true;
        else return false;
    }

    public static function reduceVacancyNonTransaction($teamID)
    {
        $team = Self::findOrFail($teamID);
        if ($team->name == 'Individual')
            return 1;
        if ($team->availedCapacity < $team->maxCapacity) {
            $team->availedCapacity += 1;
            $team->save();
            return true;
        } else
            throw TeamException("The following team can't accomodate a new member. Kindly Choose another team");
    }


    public static function maxCapacity($teamID)
    {
        return (int)Self::findOrFail($teamID)->maxCapacity;
    }


    public static function isTeamable($eventID)
    {
        return (int)DB::table('events')->where('id', $eventID)->value('teaming');
    }

    //todo: by anu changeTeam.vue
    public static function getEventByCollegeUID($collegeUID)
    {

        if (User::ifNotExist($collegeUID))
            return ['title' => 'Invalid RoR', 'error' => 'This ID is not registered'];
        return DB::table('enrollments')
            ->where([['enrollments.participantCollegeUID', $collegeUID], ['events.teaming', '=', 1]])
            ->join('events', 'enrollments.eventID', '=', 'events.id')
            ->join('teams', 'enrollments.teamID', '=', 'teams.id')
            ->select('events.name as eventName', 'events.id as eventID', 'teams.id as teamID', 'teams.name as teamName', 'enrollments.id as enrollmentID')
            ->get();


    }

    //todo: by anu changeTeam.vue
//    public static function getCurrentTeam($collegeUID, $eventID){
//
//        if (User::ifNotExist($collegeUID)||Event::isNotExist($eventID))
//            return ['title' => 'Invalid RoR', 'error' => 'This ID or event is not registered'];
//        return DB::table('enrollments')
//            ->where([['participantCollegeUID', '=', $collegeUID], ['eventID','=', $eventID]])
//            ->join('teams', 'enrollments.teamID', '=', 'teams.id')
//            ->select('teams.name', 'enrollment.teamID','enrollment.id')->get();
//
//    }

    //todo: by anu changeTeam.vue
    public static function updateTeamID($collegeUID, $enrollmentID, $newTeamID, $oldTeamID)
    {

        return DB::transaction(function () use ($collegeUID, $enrollmentID, $newTeamID, $oldTeamID) {
            $oldTeam = Team::findOrFail($oldTeamID);
            $newTeam = Team::findOrFail($newTeamID);
            $enrollment = Enrollment::findOrFail($enrollmentID);
            if ($oldTeam->name == 'Individual') {

                $newTeam->availedCapacity = $newTeam->availedCapacity +1;
                $enrollment->teamID = $newTeamID;
                $newTeam->save();
                $enrollment->save();

            } else {
                $newTeam->availedCapacity = $newTeam->availedCapacity +1;
                if($oldTeam->availedCapacity > 0) {
                    $oldTeam->availedCapacity = $oldTeam->availedCapacity - 1;
                    $oldTeam->save();
                }
                $enrollment->teamID = $newTeamID;
                $newTeam->save();
                $enrollment->save();



            }
        }


            , 5);
    }
}

