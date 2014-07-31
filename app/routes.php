<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('domain' => '{account}.l15.dev'), function()
{

	Route::get('/',function($account){
		return Redirect::to('home');
	});

	Route::get('/home',function($account){
		if (!Auth::check())
		{
		    return Redirect::to('http://l15.dev/');
		}
		return View::make('chat.index')->with(['title' => $account.' | ChatApp','account' => $account]);;
	});

	Route::get('/chat',function($account){
		if (!Auth::check())
		{
		    return Redirect::to('http://l15.dev/');
		}
		return View::make('chat.chatui')->with(['title' => $account.' | ChatApp','account' => $account]);
	});
});

Route::get('/', function()
{
	return Redirect::to('home');
});

Route::get('/home', function()
{
	if (Auth::check())
		{
		    return Redirect::to('http://'.Auth::user()->team.'.l15.dev/');
		}
	return View::make('home.index')->withTitle('ChatApp | chat for dummies');
});

Route::post('/signup',['as' => 'signup', 'uses' => 'UsersController@store']);
Route::post('/login',['as' => 'login', 'uses' => 'UsersController@login']);
Route::get('/login',function(){
if (Auth::check())
		{
		    return Redirect::to('http://'.Auth::user()->team.'.l15.dev/');
		}
	return View::make('home.index')->withTitle('Login | ChatApp');
});
Route::get('/signup',function(){
if (Auth::check())
		{
		    return Redirect::to('http://'.Auth::user()->team.'.l15.dev/');
		}
	return View::make('home.index')->withTitle('Signup | ChatApp');
});



