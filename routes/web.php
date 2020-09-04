<?php

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('channels', 'ChannelController')->except('update');
Route::resource('channels', 'ChannelController')->only('update')->middleware('auth');

Route::get('channels/{channel}/video', 'UploadVideoController@index')->name('channels.upload')->middleware('auth');
Route::post('channels/{channel}/video', 'UploadVideoController@store')->name('channels.store')->middleware('auth');

Route::resource('channels/{channel}/subscriptions', 'SubscriptionController')->only(['store', 'destroy'])->middleware('auth');

Route::get('videos/{video}', 'VideoController@show')->name('videos.show');
Route::put('videos/{video}/update', 'VideoController@update')->name('videos.update')->middleware('auth');
Route::put('videos/{video}', 'VideoController@updateViews');

Route::post('votes/{entityId}/{type}', 'VoteController@vote');
Route::delete('votes/{vote}', 'VoteController@destroy');

Route::get('videos/{video}/comments', 'CommentController@index');
Route::post('videos/{video}/comments', 'CommentController@store')->middleware('auth');
Route::get('comments/{comment}/replies', 'CommentController@show');


Auth::loginUsingId(User::all()[0]->id);
