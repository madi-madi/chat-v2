<?php

use App\Events\UserSignedUp;
use Illuminate\Support\Facades\Redis;


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


Route::get('/', function () {

	// Redis::set('name','Forsan Technology Very Nice and Stronge');
	// //return Redis::hget('preferences','length');
	// Cache::put('foo','bar',10);

	// return Cache::get('foo');

	//1- publish event with redis.

	// $data = [
	// 	'event'=> 'UserSignedUp',
	// 	'data'=>[ 
	// 		'username'=>'Ibrahim Salama',
	// 	],
	// ];
	// Redis::publish('test-channel',json_encode($data));
	
	// Auth::user() ? event(new UserSignedUp(Auth::user()->name)) : event(new UserSignedUp('Gest'));
	return view('welcome');
   // 2- Node.js + Redis subscribes the event
   // 3- Use socket.io to emit to all clients.



  //  return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('create/room','HomeController@create_room')->name('create_room');
Route::get('rooms','HomeController@get_rooms')->name('get_rooms');
Route::get('room/{id}','HomeController@get_roomById')->name('get_roomById');
Route::post('join/room','HomeController@join_user')->name('join_user');
Route::post('send/message','HomeController@send_message')->name('send_message');
Route::get('send/{id}','HomeController@get_user_by_id')->name('get_user_by_id');
Route::get('search/{name}','HomeController@search_room')->name('search_room');
Route::get('mention','HomeController@mention')->name('mention');



