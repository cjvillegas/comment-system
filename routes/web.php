<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('/', 'PostController');
Route::resource('/post-comment', 'PostCommentController');
Route::match(['get', 'post'], '/post-comment/fetch-comments', 'PostCommentController@fetchComments')->name('post-comment.fetch-comments');
