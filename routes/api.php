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
Route::post('/members/find/name/{collegeUID}','UsersController@getUserName');
Route::post('/events/find/enrollable/','API\EventController@listAll');
Route::post('/events/find/enrollable/teams/{eventID}','API\TeamController@listAll');
Route::post('/forms/events/enroll/student','API\EnrollmentController@store');
Route::post('/verify/enrollment/{EnrollmentID}','API\EnrollmentController@verify');
