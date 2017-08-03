<?php

  Route::get('/', function () {return view('index');});



  Route::group(['prefix' => 'admin'], function () {
    Route::get('/home', function () {return view('welcome');});
    Route::get('/users', 'PostController@users');
    Route::get('/post_list', 'PostController@postlist');
    Route::get('/post/{id}', 'PostController@post');
  });




