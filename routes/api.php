<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('fetch/navigation','API\NavigationController@pushAllLinks');
Route::get('fetch/user/queues/pendingActions','API\QueueController@index');
Route::get('fetch/user/queues/pendingAttendance','API\AttendenceController@index');
Route::post('approve/user/queues/approvePendingActions','API\QueueController@getApprovalDetails');
Route::post('deny/user/queues/denyPendingActions','API\QueueController@denyRequestDetails');
Route::get('fetch/user/account/transactions','API\CashFlowController@listAllTransactions');
Route::post('put/user/queues/balanceTransfer/newRequest','API\QueueController@store');
Route::post('put/user/queues/balanceRequest/newRequest','API\QueueController@storeBalanceTransferRequest');
Route::post('fetch/user/balance/currentBalance','UsersController@breadcumbBalances');
Route::get('put/user/theme/{themeName}','UsersController@setTheme');

Route::post('/members/find/name/{collegeUID}','UsersController@getUserName');
Route::get('/members/find/pendingBalance/{collegeUID}','API\CashFlowController@negativeStudentAccountBalance');
Route::post('/forms/fees/enrollment/pluckPendingBalance','API\CashFlowController@store');
Route::post('/events/find/enrollable/','API\EventController@listAll');
Route::post('/events/find/teamable/','API\EventController@listTeamableEvents');
Route::post('events/enrollment/find/events','API\TeamController@getEventList');
//Route::post('/find/byRegNo/team/','API\EnrollmentController@getTeam');
Route::post('/find/enrolled/teams/','API\TeamController@fetchTeamList');
Route::post('/put/user/data/newTeam/','API\TeamController@updateTeam');


Route::post('/events/put/attendance/request','API\AttendenceController@storeRequest');

Route::get('/events/find/enrollable/{eventID}/teams/','API\TeamController@listAll');

//Route::get('/events/find/allOccurringToday','API\EventController@todaysEvents');
Route::get('/events/all/onDate/{date}','API\EventController@findByDate');
Route::get('/events/{eventID}/find/participants','API\AttendenceController@getAllEnrolledStudents');
//todo: check below "int(eventID)" ?
Route::get('/events/{eventID}/find/verifiable/participants','API\AttendenceController@getAttendanceList');
Route::post('/forms/events/enroll/student','API\EnrollmentController@store');
Route::post('/forms/venues/register','API\VenueController@store');
Route::post('/verify/student/attendance', 'API\AttendenceController@verifyAttendance');
Route::post('/reject/student/attendance', 'API\AttendenceController@rejectAttendance');
Route::post('/forms/generate/smartCards', 'API\SmartCardController@generateCardList');

//todo: queue transactions implemention
Route::post('/forms/moneyTransfer/transaction/initiate','API\EnrollmentController@store');
Route::post('/verify/enrollment/{EnrollmentID}','API\EnrollmentController@verify');
Route::post('/verify/venue/{VenueID}','API\VenueController@verify');

//searching routes
Route::post('/search/transactions/by-data/','API\CashFlowController@search');


Route::apiResource('/forms/events/','API\EventController');
//todo: anu
Route::apiResource('/forms/events/team','API\TeamController');


//test route
Route::get('/test/{param}','SystemController@test');
