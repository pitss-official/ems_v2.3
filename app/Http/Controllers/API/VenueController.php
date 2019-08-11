<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function __construct()
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
        //
        $validatedData = $request->validate([
            'type' => 'bail|required|integer|between:1,10',
            'name' => 'bail|required|string|min:1|max:90',
            'primaryAddressLine' => 'bail|required|string|min:1|max:90',
            'secondaryAddressLine' => 'nullable|string|min:1|max:90',
            'tertiaryAddressLine' => 'nullable|string|min:1|max:90',
            'shortAddress' => 'bail|required|string|min:1|max:50',
            'capacity' => 'bail|required|integer|min:1',
            'price' => 'bail|required|numeric|min:0',
            'coordinatorsRequired' => 'bail|required|integer|min:1'
        ]);
        $venue = new Venue();
        $venue->type = $validatedData['type'];
        $venue->name = $validatedData['name'];
        $venue->primaryAddressLine = $validatedData['primaryAddressLine'];
        $venue->secondaryAddressLine = $validatedData['secondaryAddressLine'];
        $venue->tertiaryAddressLine = $validatedData['tertiaryAddressLine'];
        $venue->shortAddress = $validatedData['shortAddress'];
        $venue->capacity = $validatedData['capacity'];
        $venue->price = $validatedData['price'];
        $venue->coordinatorsRequired = $validatedData['coordinatorsRequired'];
        $venue->registeredBy = Auth::guard('api')->user()->collegeUID;
        $venue->save();
        return $venue->id;
    }
    public function verify($id)
    {
        return (int)Venue::isExist($id);
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
}
