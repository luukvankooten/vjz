<?php

Route::post('/login', 'Api\LoginController@login');
Route::get('/validate', 'Api\ValidateController@validation');

Route::get('/user', function (){
    return auth()->user();
})->middleware(['auth:api', 'scope:app-login']);