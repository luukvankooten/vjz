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
 * Login routes
 */
Route::prefix('login')->group(function (){
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Auth\LoginController@login');
});

/*
 * Logout route
 */
Route::post('logout', 'Auth\LoginController@logout')->name('logout');