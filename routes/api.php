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
Route::get('/guest/register/fetch/events','API\GuestController@events')->middleware('guest','throttle: 40,1');
//todo change requests throttle
Route::post('/guest/register/self/','API\GuestController@register')->middleware('guest','throttle: 60,1');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('fetch/navigation','API\NavigationController@pushAllLinks')->middleware('auth:api');
Route::get('fetch/user/queues/pendingActions','API\QueueController@index')->middleware('auth:api');
Route::get('fetch/user/queues/pendingAttendance','API\AttendenceController@index')->middleware('auth:api');
Route::get('fetch/user/account/transactions','API\CashFlowController@listAllTransactions')->middleware('auth:api');
Route::get('put/user/theme/{themeName}','UsersController@setTheme')->middleware('auth:api');
Route::get('/members/find/pendingBalance/{collegeUID}','API\CashFlowController@negativeStudentAccountBalance')->middleware('auth:api');
Route::get('/events/find/enrollable/{eventID}/teams/','API\TeamController@listAll')->middleware('auth:api');
Route::get('/events/all/onDate/{date}','API\EventController@findByDate')->middleware('auth:api');
Route::get('/events/{eventID}/find/participants','API\AttendenceController@getAllEnrolledStudents')->middleware('auth:api');
Route::get('/events/{eventID}/find/verifiable/participants','API\AttendenceController@getAttendanceList')->middleware('auth:api');

Route::post('/events/put/attendance/request','API\AttendenceController@storeRequest')->middleware('auth:api');
Route::post('put/user/queues/balanceRequest/newRequest','API\QueueController@storeBalanceTransferRequest')->middleware('auth:api');
Route::post('deny/user/queues/denyPendingActions','API\QueueController@denyRequestDetails')->middleware('auth:api');
Route::post('put/user/queues/balanceTransfer/newRequest','API\QueueController@store')->middleware('auth:api');
Route::post('fetch/user/balance/currentBalance','UsersController@breadcumbBalances')->middleware('auth:api');
Route::post('approve/user/queues/approvePendingActions','API\QueueController@getApprovalDetails')->middleware('auth:api');
Route::post('/members/find/name/{collegeUID}','UsersController@getUserName')->middleware('auth:api');
Route::post('/forms/fees/enrollment/pluckPendingBalance','API\CashFlowController@store')->middleware('auth:api');
Route::post('/events/find/enrollable/','API\EventController@listAll')->middleware('auth:api');
Route::post('/events/find/teamable/','API\EventController@listTeamableEvents')->middleware('auth:api');
Route::post('events/enrollment/find/events','API\TeamController@getEventList')->middleware('auth:api');
Route::post('/find/enrolled/teams/','API\TeamController@fetchTeamList')->middleware('auth:api');
Route::post('/put/user/data/newTeam/','API\TeamController@updateTeam')->middleware('auth:api');
Route::post('/put/events/budget/newBudget','API\BudgetController@store')->middleware('auth:api');

Route::post('/forms/events/enroll/student','API\EnrollmentController@store')->middleware('auth:api');
Route::post('/forms/venues/register','API\VenueController@store')->middleware('auth:api');
Route::post('/verify/student/attendance', 'API\AttendenceController@verifyAttendance')->middleware('auth:api');
Route::post('/reject/student/attendance', 'API\AttendenceController@rejectAttendance')->middleware('auth:api');
Route::post('/forms/generate/smartCards', 'API\SmartCardController@generateCardList')->middleware('auth:api');

Route::post('/forms/moneyTransfer/transaction/initiate','API\EnrollmentController@store')->middleware('auth:api');
Route::post('/verify/enrollment/{EnrollmentID}','API\EnrollmentController@verify')->middleware('auth:api');
Route::post('/verify/venue/{VenueID}','API\VenueController@verify')->middleware('auth:api');
Route::post('/search/transactions/by-data/','API\CashFlowController@search')->middleware('auth:api');


Route::apiResource('/forms/events/','API\EventController')->middleware('auth:api');
Route::apiResource('/forms/events/team','API\TeamController')->middleware('auth:api');


Route::get('/test/{param}','SystemController@test')->middleware('auth:api');
