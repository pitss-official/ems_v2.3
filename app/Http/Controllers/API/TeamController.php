<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
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
            'teamName' => 'bail|required|min:5|unique:teams,id,eventID',
            'eventID' => 'bail|required|integer|min:0|exists:events,id',
            'description' => 'string|min:5',
    ]);

        $coordinatorUID = Auth::guard('api')->user()->collegeUID;
        if (Team::isNotExistByName($validatedData['teamName'])){
            $team = new Team();
            $team->name = $validatedData['teamName'];
            $team->eventID = $validatedData['eventID'];
            $team->description = $validatedData['description'];
            $team->save();
            return $team->id;

        }

        else{
            return[
                'error'=>'The team already exists',
                'message'=>'Try another team name',
            ];
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
        return Team::getAllEnrollable($eventID);
    }
}
