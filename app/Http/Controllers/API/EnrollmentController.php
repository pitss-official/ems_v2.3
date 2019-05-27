<?php

namespace App\Http\Controllers\API;

use App\Enrollment;
use App\Event;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Hash;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function getAllEnrolledStudents($eventID)
    {
        $students = Enrollment::getAllStudents($eventID)->pluck('participantCollegeUID');
        $response = [];
        $number = 1;
        foreach ($students as $student) {
            $user = User::where('collegeUID', $student)->firstOrFail();
            $name = $user->firstName . ' ' . $user->middleName . ' ' . $user->lastName;
            array_push($response, [$number, $student, $name, 0]);
            $number++;
        }
        return new JsonResponse($response, 200);
        //return Json::encode($array);
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

        //only for coordinator based enrollment
        $validatedData = $request->validate([
            'email' => 'bail|required|email',
            'firstName' => 'bail|required|string|min:1|max:25',
            'middleName' => 'nullable|string|min:1|max:25',
            'lastName' => 'nullable|string|min:1|max:25',
            'fathersName' => 'nullable|string|min:1|max:100',
            'mobile' => 'bail|required|numeric|digits:10',
            'altMobile' => 'nullable|integer|digits:10|unique:users',
            'gender' => 'bail|required|integer|digits_between:0,3',
            'eventID' => 'bail|required|integer|exists:events,id',
            'collegeUID' => 'bail|required|unique:enrollments,participantCollegeUID,eventID' . $request->eventID . '|digits:8|numeric',
            'address' => 'nullable|string|max:250',
            'nationality' => 'nullable|string|max:5',
            'bloodGroup' => 'nullable|string|max:5',
            'birthday' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
            'team' => 'bail|nullable|integer|exists:teams,id,eventID,' . $request->eventID,
        ]);
        $coordinatorUID = Auth::guard('api')->user()->collegeUID;
        if (User::ifNotExist($validatedData['collegeUID'])) {
            $request->validate([
                'email' => 'unique:users,email',
                'mobile' => 'unique:users,mobile',
                'collegeUID' => 'unique:users,collegeUID',
            ]);
            $user = new User();
            $user->firstName = $validatedData['firstName'];
            $user->middleName = $validatedData['middleName'];
            $user->lastName = $validatedData['lastName'];
            $user->collegeUID = $validatedData['collegeUID'];
            $user->gender = $validatedData['gender'];
            $user->address = $validatedData['address'];
            if ($validatedData['nationality'] == null)
                $validatedData['nationality'] = 'IN';
            $user->nationality = $validatedData['nationality'];
            $user->bloodGroup = $validatedData['bloodGroup'];
            $user->birthday = $validatedData['birthday'];
            $user->mobile = $validatedData['mobile'];
            $user->altMobile = $validatedData['altMobile'];
            $user->email = $validatedData['email'];
            $user->fathersName = $validatedData['fathersName'];
            $user->createdBy = $coordinatorUID;
            $user->password = \Illuminate\Support\Facades\Hash::make(random_bytes(10));
            $user->status = 1;
            $user->referenceUID = $coordinatorUID;
            $user->save();
            $user->openAccount();
        }
        $enrollment = new Enrollment();
        $enrollment->eventID = $validatedData['eventID'];
        $event = Event::findOrFail($validatedData['eventID']);
        if ($validatedData['amount'] >= $event->ticketPrice) {
            return $enrollment->enrollWithFullPayment($validatedData['collegeUID'], $coordinatorUID, $validatedData['team']);

        } elseif ($validatedData['amount'] >= ($event->minimumPayment * $event->ticketPrice / 100)) {
            return $enrollment->reserveSeatViaPartialPayment($validatedData['collegeUID'], $coordinatorUID, $validatedData['amount'], $validatedData['team']);
        } else {
            return ['error' => 'Invalid Amount', 'message' => 'Kindly enter a valid amount to proceed'];
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
        return Enrollment::findOrFail($id);
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
