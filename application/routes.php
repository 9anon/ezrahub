<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


/*******************************************
*  Routes related to personal administration
*  functions
*******************************************/
//route if forgot password
Route::get('forgotpassword', 'user@forgot_password');

//signup
Route::post('signup', 'user@new_post');

//login
Route::get('login', 'user@login');
Route::post('login', 'user@login_post');

//logout
Route::get('logout', 'user@logout');

//user profile
Route::get('user/(:any?)', 'user@index');

/*******************************************
*  Routes related to threads and posts
*******************************************/
Route::get('thread/(:num)/(:all?)', 'thread@index');

//auto thread updating
Route::post('thread/update/(:num)', 'thread@update');

//retrieving, editing or quoting posts
Route::get('post/quote/(:num)', 'post@quote');
Route::get('post/edit/(:num)', 'post@edit_form');
Route::post('post/edit/(:num)', 'post@edit');

/*******************************************
*  Routes requiring not banned
*******************************************/
Route::group(array('before' => 'not_banned'), function(){
    Route::get('thread/new', 'thread@new');
    Route::post('thread/new', 'thread@new_post');
    Route::post('post/new/(:num)', 'post@new_post');
});

//show reputation interface
Route::get('rep/show/(:num)', 'rep@index');

/*******************************************
*  Routes requiring auth
*******************************************/
Route::group(array('before' => 'auth'), function(){
    Route::get('me', 'user@index'); //current user

    //editing avatar
    Route::get('user/avatar/form', 'user@edit_avatar');
    Route::post('user/avatar/edit', 'user@edit_avatar_post');
    Route::post('user/avatar/delete', 'user@delete_avatar');

    //editing bio
    Route::get('user/bio/form', 'user@edit_bio');
    Route::post('user/bio/edit', 'user@edit_bio_post');

    //changing password
    Route::post('user/password/edit', 'user@edit_password');

    //changing email
    Route::post('user/email/edit', 'user@edit_email');

    //thread stuff
    Route::post('thread/read/page/(:num)', 'thread@read_all');
    Route::get('thread/random', 'thread@random');

    //post and thread deletion/editing
    Route::post('thread/delete/(:num)', 'thread@delete');
    Route::post('post/delete/(:num)', 'post@delete');
    Route::post('post/edit/(:num)', 'post@edit');

    //reputation
    Route::post('rep/up/(:num)', 'rep@up');
    Route::post('rep/down/(:num)', 'rep@down');

    //send messages
    Route::post('message/send/(:num)', 'user@send_message');
    //open message
    Route::get('message/read/(:num)', 'user@read_message');

});

/*******************************************
*  Routes related to moderation+ activities
*******************************************/
Route::group(array('before' => 'auth|can_mod'), function(){
    //ban users
    Route::get('mod/ban/user/(:num)', 'moderation@ban_user');
    Route::post('mod/ban/user/(:num)', 'moderation@ban_user_post');

    //sticky, lock and bumplock threads
    Route::post('thread/sticky/(:num)', 'thread@sticky');
    Route::post('thread/lock/(:num)', 'thread@lock');
    Route::post('thread/bumplock/(:num)', 'thread@bumplock');
});

/*******************************************
*  Routes related for (fairly) static pages with nice
*  vanity urls
*******************************************/
Route::get('banned', 'home@banned');
//route to go to rules
Route::get('rules', 'home@rules');
//route to go to about page
Route::get('about', 'home@about');

//homepage pages
Route::get('page/(:num)', 'home@page');

//homepage routes
Route::get('/', 'home@index');
Route::get('users/online', 'home@online_users');

//search
Route::get('search', 'search@search');


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

Route::filter('can_mod', function() {
    if (!(Auth::user()->has_role('mod') || Auth::user()->has_role('admin'))) {
        return Redirect::to('/');
    }
});

Route::filter('not_banned', function() {
    if (Auth::check()) {
        if (Auth::user()->banned) {
            return Redirect::to('banned');
        }
    }

    // if (IPBanUtil::banned(Request::ip)) {
    //     return Redirect::to('login');
    // }
});
