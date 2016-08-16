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

Route::resource('/','ArticleController');
Route::resource('articles','ArticleController');
Route::resource('category','ArticleController@categoryA');
Route::resource('articles/{article_id}/like','ArticleController@like');
Route::resource('articles/{article_id}/comments','CommentController');
Route::resource('articles/usercheck','ArticleController@usercheck');
Route::resource('articles/emailcheck','ArticleController@emailcheck');
Route::get('auth/logout','Auth\AuthController@logout');


