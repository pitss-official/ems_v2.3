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
}

