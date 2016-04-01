<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('contact','WelcomeController@contact');
Route::get('about','PagesController@about');
Route::get('ekarat','PagesController@ekarat');
Route::get('en_scan','EN_Scan_Controller@en_scan');
Route::get('en_scan_graph','EN_Scan_Controller@en_scan_graph');
Route::get('en_scan_search','EN_Scan_Controller@en_scan_search');
Route::get('en_scan_search_feed','EN_Scan_Controller@en_scan_search_feed');
Route::post('ajax/refresh_log','EN_Scan_Controller@refresh_scan_log');
Route::post('ajax/scan_summary_api','EN_Scan_Controller@scan_summary_api');
Route::get('home', 'HomeController@index');

Route::get('/', function () {
    return view('welcome');
    //return 'hello world';
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::get('sendemail', function () {

    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('evrae.data@gmail.com', 'Learning Laravel');

        $message->to('supachok_i@hotmail.com')->subject('Learning Laravel test email');

    });

    return "Your email has been sent successfully";

});