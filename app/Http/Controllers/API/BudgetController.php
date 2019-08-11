<?php

namespace App\Http\Controllers\API;

use App\Budget;
use App\Event;
use App\Http\Requests\BudgetCreateRequest;
use App\User;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    function store(BudgetCreateRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
    $event=Event::findOrFail($validatedData['eventID']);
    $totalBudgetedAmount=Budget::where('eventID',$event->id)->sum('value');
    $eventValue=$event->ticketPrice*$event->seats;
    $budgetValue=$validatedData['value'];
    if($validatedData['isPercentage']==true){
        $budgetValue*=$eventValue/100;
    }
    if(($totalBudgetedAmount+$budgetValue)>$eventValue)
        return ['result'=>'error','message'=>'Budget Overflow'];
    $budgetParent=Budget::where([['parent','=',true],['eventID','=',$event->id]])->first();
    if($budgetParent==null)
    {
        $budget=Budget::create([
            'name'=>$validatedData['budgetName'],
            'eventID'=>$validatedData['eventID'],
            'value'=>$budgetValue,
            'remainingValue'=>$budgetValue,
            'parent'=>true,
            'createdBy'=>User::getCurrentAPIUser()['collegeUID'],
            'account'=>$validatedData['account'],
        ]);
        return ['result'=>'success','id'=>$budget->id];
    }
    else
        {
            $budget=Budget::create([
                'name'=>$validatedData['budgetName'],
                'eventID'=>$validatedData['eventID'],
                'value'=>$budgetValue,
                'remainingValue'=>$budgetValue,
                'parent'=>false,
                'account'=>$validatedData['account'],
                'createdBy'=>User::getCurrentAPIUser()['collegeUID']
            ]);
            return ['result'=>'success','id'=>$budget->id];
        }
    }
}
