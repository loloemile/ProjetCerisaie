<?php

use App\Http\Controllers\SejourController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Session;

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
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

/* * *********************************************************************** */
/* * ******  Authentification ********************************************** */
/* * *********************************************************************** */


Route::get('/getLogin', function () {
    return view('authentification/formLogin');
});
Route::get('/getLogout', [App\Http\Controllers\UtilisateurController::class, 'signOut']);

Route::post('/login',[App\Http\Controllers\UtilisateurController::class, 'signIn']);

/* * *********************************************************************** */
/* * ******  Sejour ********************************************** */
/* * *********************************************************************** */


Route::get('/getListeSejour', [App\Http\Controllers\SejourController::class, 'listeSejours'])->middleware('connect');

/*
 * Ajout Séjour
 */

//get ajout
Route::get('/ajoutSejour',[App\Http\Controllers\SejourController::class, 'ajoutSejour']);

// post ajout
Route::post('/ajoutSejour', [
    'as' => 'postajoutSejour',
    'uses' => 'SejourController@postajoutSejour'
]);

Route::get('/modifierSejour/{id}', [App\Http\Controllers\SejourController::class, 'modification']);

//post modif
Route::post('/postmodifierSejour/{id}', [
    'as' => 'postmodifierSejour',
    'uses' => 'SejourController@postmodifierSejour'
]);
// suppression
Route::get('/supprimerSejour/{id}', [App\Http\Controllers\SejourController::class, 'suppression']);

Route::get('/miseajour/{pwd}', [App\Http\Controllers\UtilisateurController::class, 'updatePassword']);


