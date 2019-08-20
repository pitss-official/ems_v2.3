<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Eventdate;
use App\Http\Controllers\Controller;
use App\System;
use App\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(){
        return true;
    }
    public function listAll()
    {
        $this->authorize('listAll',Event::class);
        return Event::getAllEnrollable();
    }

    public function listTeamableEvents()
    {
        $this->authorize('listTeamable',Event::class);
        return Event::getAllTeamable();
    }

    public function findByDate($date)
    {
        $this->authorize('listByDate',Event::class);
        return Event::findByDate($date);
    }

    public function store(Request $request)
    {
        $this->authorize('create',Event::class);
        //todo:check again
        $validatedData= System::sanitize($request->validate([
            'eventName'=>'bail|required|string|min:3|max:150',
            'startDate'=>'bail|required|date|after_or_equal:today',
            'endDate'=>'required|date|after_or_equal:today',
            'description'=>'required|string|min:10|max:10240',
            'seats'=>'required|integer|min:1|max:9999999999|numeric',
            'ticketPrice'=>'required|between:0,999999999999999',
            'supportMobile'=>'required|numeric|digits:10',
            'supportAltMobile'=>'nullable|numeric|digits:10',
            'reservationCharges'=>'required|between:0,100',
            'maxIncentives'=>'required|between:0,100',
            'approvalFiling'=>'boolean|required|',
            'teaming'=>'boolean|required|',
            'approvalStatus'=>'boolean|required|',
            'approvalDate'=>'required|date',
            'approverName'=>'required|string|max:150|min:3',
            'approverMobile'=>'nullable|numeric|digits:10',
            'approverAddress'=>'nullable|string|alpha_num|max:150',
            'approverEmail'=>'nullable|email|string',
            'supportEmail'=>'required|email|string',
            'dates'=>'array|required',
            'dates.*.id'=>'required|integer|min:0',
            'minimumUserLevel'=>'required|numeric|between:0,1025',
        ]));//todo: coor req in days
        $validatedData=array_merge($validatedData,System::sanitize($request->validate([
            'dates.*.date'=>'required|before_or_equal:'.$validatedData['endDate'].'|after_or_equal:'.$validatedData['startDate'],
            'dates.*.startTime'=>'nullable|date_format:H:i',
            'dates.*.endTime'=>'nullable|date_format:H:i',
            'dates.*.motive'=>'nullable|string|max:255',
            'dates.*.description'=>'nullable|string|max:10240',
            'dates.*.coordinatorsRequired'=>'required|min:1|numeric',
            //todo:recheck time validation with merge req
        ])));
        $event = new Event();
        try {
            $currentUser = User::getCurrentAPIUser()['collegeUID'];
        }
        catch (\Exception $e)
        {
            throw new \Exception("Unauthorized");
        }
        $event->name=$validatedData['eventName'];
        $event->requesterID=$currentUser;//todo:
        $event->approvalID=$currentUser;//todo:implement approval of events
        $event->ticketPrice=$validatedData['ticketPrice'];
        $event->startDate=$validatedData['startDate'];
        $event->endDate=$validatedData['endDate'];
        $event->seats=$validatedData['seats'];
        $event->teaming=$validatedData['teaming'];
        $event->maxIncentiveRate=$validatedData['maxIncentives'];
        $event->supportMail=$validatedData['supportEmail'];
        $event->supportMobile=$validatedData['supportMobile'];
        $event->altSupportMobile=$validatedData['supportAltMobile'];
        $event->minimumPayment=$validatedData['reservationCharges'];
        $event->approvalStatus=$validatedData['approvalStatus'];
        $event->approvalDate=$validatedData['approvalDate'];
        $event->fillingStatus=$validatedData['approvalFiling'];
        $event->minimumUserPower=$validatedData['minimumUserLevel'];
        $event->visibility=$validatedData['approvalStatus'];
        $event->saveNew();//always call savenew to create accounts and defaut teams
        foreach ($validatedData['dates'] as $date)
        {
            if(is_null($date['startTime'])or is_null($date['motive'])or is_null($date['endTime'])or $date['motive']=="")
                continue;
            $eventDate= new Eventdate();
            $eventDate->date=substr($date['date'],0,10);
            $eventDate->motive=$date['motive'];
            $eventDate->description=$date['description'];
            $eventDate->coordinatorsRequired=$date['coordinatorsRequired'];
            $eventDate->startTime=$date['startTime'];
            $eventDate->endTime=$date['endTime'];
            $eventDate->eventID=$event->id;
            $eventDate->save();
        }
        return $event->id;
    }
}
