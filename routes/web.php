<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/payment/status', 'API\OnlinePaymentController@paymentResponseActionEval');

//todo remove production
Route::get('/upio',function (){
   $rand=\App\System::randAlphaNum(8);
   echo $rand;
   echo '<br>';
   echo \Illuminate\Support\Facades\Hash::make($rand);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'API\DashboardController@test')->name('test');

Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d/-/_.]+)?' );
