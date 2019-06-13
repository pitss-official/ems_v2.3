<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Enrollment;
use App\Event;
use App\Exceptions\EnrollmentException;
use App\Http\Controllers\Controller;
use App\User;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Hash;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    public function getAllEnrolledStudents(int $eventID)
    {
        return DB::table('enrollments')->where('enrollments.eventID',$eventID)
            ->join('users','enrollments.participantCollegeUID','=','users.collegeUID')
            ->join('accounts','enrollments.participantCollegeUID','=','accounts.number')
            ->join('teams','enrollments.teamID','=','teams.id')
            ->select('users.firstName','users.middleName','users.lastName','users.collegeUID','users.school','users.branch','accounts.balance','teams.name','enrollments.id')
            ->orderBy('teams.name','asc')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'eventID' => 'bail|required|integer|exists:events,id',
            'collegeUID' => 'bail|required|unique:enrollments,participantCollegeUID,eventID' . $request->eventID . '|digits:8|numeric',
            'amount' => 'required|numeric|min:0',
            'team' => 'bail|nullable|integer|exists:teams,id,eventID,' . $request->eventID,
        ]);
        $coordinatorUID = Auth::guard('api')->user()->collegeUID;
        if (User::isNotExist($validatedData['collegeUID'])) {
            $validatedData=array_merge($request->validate([
                'email' => 'bail|required|email',
                'course'=>'bail|required|string|min:3|max:255',
                'school'=>'bail|required|string|min:1|max:2',
                'fathersName' => 'nullable|string|min:1|max:100',
                'firstName' => 'bail|required|string|min:1|max:25',
                'middleName' => 'nullable|string|min:1|max:25',
                'lastName' => 'nullable|string|min:1|max:25',
                'mobile' => 'bail|required|numeric|digits:10',
                'altMobile' => 'nullable|integer|digits:10|unique:users',
                'gender' => 'bail|required|integer|digits_between:0,3',
                'address' => 'nullable|string|max:250',
                'nationality' => 'nullable|string|max:5',
                'bloodGroup' => 'nullable|string|max:5',
                'birthday' => 'nullable|date',
            ]),$validatedData);
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
            $user->school=$validatedData['school'];
            $user->branch=$validatedData['course'];
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
            try{
                    $user->openAccount();
            }
            catch(\Exception $e){
                echo "Exception";
            }
            finally {
                if (Account::ifNotExist($user->collegeUID))
                {
                    $user->delete();
                    throw new EnrollmentException("Account Creation Failed, Data has been rolled back");
                }
            }
        }
        $enrollment = new Enrollment();
        $enrollment->eventID = $validatedData['eventID'];
        $event = Event::findOrFail($validatedData['eventID']);
        if ($validatedData['amount'] >= $event->ticketPrice) {
            return ["result"=>'success',"id"=>$enrollment->enrollWithFullPayment((int)$validatedData['collegeUID'], $coordinatorUID, $validatedData['team'])];

        } elseif ($validatedData['amount'] >= ($event->minimumPayment * $event->ticketPrice / 100)) {
            return $enrollment->reserveSeatViaPartialPayment((int)$validatedData['collegeUID'], $coordinatorUID, $validatedData['amount'], $validatedData['team']);
        } else {
            return ["result"=>'error','error' => 'Invalid Amount', 'message' => 'Kindly enter a valid amount to proceed'];
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
    public function verify($id)
    {//todo:check_verifing_methods http
        /*example
         * fetch("http://127.0.0.1:8000/api/verify/enrollment/%3Cscript%3E%20Sfdump%20=%20window.Sfdump%20%7C%7C%20(function%20(doc)%20%7B%20var%20refStyle%20=%20doc.createElement('style'),%20rxEsc%20=%20/([.*+?^${}()|\\[\\]\\/\\\\])/g,%20idRx%20=%20/\\bsf-dump-\\d+-ref[012]\\w+\\b/,%20keyHint%20=%200%20%3C=%20navigator.platform.toUpperCase().indexOf(%27MAC%27)%20?%20%27Cmd%27%20:%20%27Ctrl%27,%20addEventListener%20=%20function%20(e,%20n,%20cb)%20{%20e.addEventListener(n,%20cb,%20false);%20};%20(doc.documentElement.firstElementChild%20||%20doc.documentElement.children[0]).appendChild(refStyle);%20if%20(!doc.addEventListener)%20{%20addEventListener%20=%20function%20(element,%20eventName,%20callback)%20{%20element.attachEvent(%27on%27%20+%20eventName,%20function%20(e)%20{%20e.preventDefault%20=%20function%20()%20{e.returnValue%20=%20false;};%20e.target%20=%20e.srcElement;%20callback(e);%20});%20};%20}%20function%20toggle(a,%20recursive)%20{%20var%20s%20=%20a.nextSibling%20||%20{},%20oldClass%20=%20s.className,%20arrow,%20newClass;%20if%20(/\\bsf-dump-compact\\b/.test(oldClass))%20{%20arrow%20=%20%27&", {"credentials":"include","headers":{"accept":"application/json, text/plain, *
         * /*","accept-language":"en-US,en;q=0.9","x-csrf-token":"tEx4wF2UG5uKrwy2wOHo3tPImrIw9ToJapkujN1c","x-requested-with":"XMLHttpRequest","x-xsrf-token":"eyJpdiI6IkZTV1wvWFNDaE5oc3RodWlvWlRkSm1BPT0iLCJ2YWx1ZSI6ImhuakZsaENxd1NzZnkxR0VrdFlhU3FEZ0FsR0Z2QTBnKzVlVmp5WGNvMHlWOHNvZk12c3RGZExQWjl1MHpaaWMiLCJtYWMiOiJhMWYxMzlkYjdkZDllZmJlY2UyNzU0ZmJkODk0ZGI4ZjRmYmRmMGE2ZWQ0ZGYyYmU0OWQyZTFkNTMxZTY3NjMzIn0="},"referrer":"http://127.0.0.1:8000/serve/forms/enrollment/new","referrerPolicy":"no-referrer-when-downgrade","body":null,"method":"POST","mode":"cors"});
         */
        //catchable: enrollment vue
        $i=0;
        try{
        $i= (int)Enrollment::isExist($id);}
        catch(\Exception $exception)
        {
            die("error");
        }finally
        {
            return $i;
        }
    }


}
