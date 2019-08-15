<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VenueCreateRequest;
use App\User;
use App\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(VenueCreateRequest $request)
    {
        $validatedData = $request->validatedAndSanitized();
        $this->authorize('create',Venue::class);
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
        $venue->registeredBy = User::getCurrentAPIUser()['collegeUID'];
        $venue->save();
        return $venue->id;
    }
    public function verify($id)
    {
        $this->authorize('verify',Venue::class);
        return (int)Venue::isExist($id);
    }
}
