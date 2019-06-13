<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        if (DB::table('teams')->where('id', $teamID)->value('name') == 'Individual')
            return ['Individual'];
        $availedCapacity = DB::table('teams')->where('id', $teamID)->value('availedCapacity');
        if ($availedCapacity < Self::maxCapacity($teamID))
            DB::table('teams')->where('id', $teamID)->update(['availedCapacity'], $availedCapacity - 1);
        else
            return ['error' => 'Team Capacity Exceeded', 'message' => "The following team can't accomodate a new member. Kindly Choose another team"];
    }

    public static function maxCapacity($teamID)
    {
        return DB::table('teams')->where('id', $teamID)->value('availedCapacity');
    }

    public static function isTeamable($eventID){
        return (int)DB::table('events')->where('id',$eventID)->value('teaming');
    }
    public static function getAllEnrollable($eventID)
    {//this method is used at the time of enrollment for finding teams for an event
        return Team::where([
            ['eventID', '=', $eventID],
            ['availedCapacity', '<=', 'maxCapacity']
        ])->get();
    }


    //todo: by anu changeTeam.vue
    public static function getEventByCollegeUID($collegeUID){

        if (User::ifNotExist($collegeUID))
            return ['title' => 'Invalid RoR', 'error' => 'This ID is not registered'];
        return DB::table('enrollments')
            ->where('participantCollegeUID', $collegeUID)
            ->join('events', 'enrollments.eventID', '=', 'events.id')
            ->join('teams','enrollments.teamID','=','teams.id')
            ->select('events.name', 'events.id','teams.id','teams.name')->get();




    }

    //todo: by anu changeTeam.vue
    public static function getCurrentTeam($collegeUID, $eventID){

        if (User::ifNotExist($collegeUID)||Event::isNotExist($eventID))
            return ['title' => 'Invalid RoR', 'error' => 'This ID or event is not registered'];
        return DB::table('enrollments')
            ->where([['participantCollegeUID', '=', $collegeUID], ['eventID','=', $eventID]])
            ->join('teams', 'enrollments.teamID', '=', 'teams.id')
            ->select('teams.name', 'enrollment.teamID','enrollment.id')->get();

    }

    //todo: by anu changeTeam.vue
    public static function updateTeamID($collegeUID, $eventID, $newTeamID, $oldTeamID){
        DB::table('teams')->where('teamID', '=', $newTeamID)->increment('availedCapacity');

        DB::table('teams')->where('teamID', '=', $oldTeamID)->decrement('availedCapacity');
        return DB::table('enrollments')->where([['participantUID','=',$collegeUID], ['eventID','=',$eventID]])->update(['teamID'=>$newTeamID]);

    }
}

