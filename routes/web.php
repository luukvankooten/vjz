<?php

/*
 * Index as dashboard
 */
Route::get('/', 'AuthController@index');


/*
 * Consult routes
 */
Route::prefix('consult')->group(function (){
    Route::get('/', [
        'uses' => 'ConsultController@index',
        'icon' => 'fa-plus-square',
    ]);

    Route::post('/', 'ConsultController@store');
});

/*
 * Agenda routes
 */
Route::prefix('agenda')->group(function (){
    Route::get('/', [
        'uses' => 'CalendarController@index',
        'icon' => 'fa-calendar',
    ]);
});

Route::prefix('afspraak')->group(function () {
    Route::get('/', [
        'uses' => 'CalendarController@create',
        'icon' => 'fa-calendar-plus-o'
    ]);
    Route::post('/', 'CalendarController@store');
});

/*
 * Charts Routes
 */
Route::prefix('statistieken')->group(function (){
    Route::get('/', [
        'uses' => 'StaticController@index',
        'icon' => 'fa-pie-chart',
    ]);
});

/*
 * Charts Routes
 */
Route::prefix('beeldbank')->group(function (){
    Route::get('/', [
        'uses' => 'DocsController@index',
        'icon' => 'fa-files-o',
    ]);
});
/*
 * Treatments routes
 */
Route::prefix('behandelingen')->group(function (){
    Route::get('/', [
        'uses' => 'TreatmentController@index',
        'icon' => 'fa-inbox',
    ]);
    Route::get('{consult}', 'TreatmentController@show');
});

/*
 * Reports routes
 */
Route::prefix('rapportages')->group(function () {
    Route::get('/', [
        'uses' => 'ReportController@index',
        'icon' => 'fa-bar-chart',
    ]);

    Route::get('verzekerden', 'ReportController@index');
    Route::get('behandelden', 'ReportController@index');
    Route::get('rapport', 'ReportController@index');
});

/*
 * Register routes
 */
Route::prefix('registreer')->group(function (){
    Route::get('/', [
        'uses' => 'Auth\RegisterUserController@index',
        'icon' => 'fa-user-plus',
    ]);

    Route::post('/', 'Auth\RegisterUserController@store');
});

/*
 * Roles routes
 */
Route::prefix('rollen')->group(function (){
    Route::get('/', [
        'uses' => 'Auth\RegisterRoleController@index',
        'icon' => 'fa-id-badge',
    ]);

    Route::post('/', 'Auth\RegisterRoleController@store');
});

/*
 * Permissions routes
 */
Route::prefix('permissies')->group(function (){
    Route::get('/', [
        'uses' => 'Auth\RegisterPermissionController@index',
        'icon' => 'fa-key',
    ]);

    Route::post('/', 'Auth\RegisterPermissionController@store');
});

/*
 * Groups routes
 */
Route::prefix('groepen')->group(function (){
    Route::get('/', [
        'uses' => 'GroupController@index',
        'icon' => 'fa-users',
    ]);

    Route::post('/', 'GroupController@store');

    Route::get('koppelen', 'GroupController@show');
});

/*
 * medicines routes
 */
Route::prefix('medicijnen')->group(function (){
    Route::get('/', [
        'uses' => 'MedicineController@index',
        'icon' => 'fa-medkit',
    ]);

    Route::post('/', 'MedicineController@store');
});

/*
 * disease routes
 */
Route::prefix('aandoeningen')->group(function (){
    Route::get('/', [
        'uses' => 'DiseaseController@index',
        'icon' => 'fa-wheelchair',
    ]);

    Route::post('/', 'DiseaseController@store');
});
/*
 * Admin Routes
 */
Route::prefix('oauth2')->group(function() {
    Route::get('/', [
        'uses' => 'AdminController@index',
        'icon' => 'fa-server',
        'as' => 'Oauth2'
    ]);
});


/*
 * Settings Route.
 */
Route::prefix('instellingen')->group(function (){
    Route::get('/', [
        'uses' => 'SettingsController@index',
        'as' => 'instellingen'
    ]);

    Route::post('/', 'SettingsController@update');
});

/**
 * Ajax Routes
 */
Route::prefix('ajax')->group(function () {
    Route::get('agenda', 'Ajax\CalendarController@appointments');
    Route::get('afspraken', 'Ajax\CalendarController@check');
});

/*
 * Login routes
 */
Route::prefix('login')->group(function (){
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Auth\LoginController@login');
});


Route::prefix('bestanden')->group(function() {
    Route::get('{path}', 'FilesController@show')->where(['path' => '.*']);
});



/*
 * Logout route
 */
Route::post('logout', 'Auth\LoginController@logout')->name('logout');