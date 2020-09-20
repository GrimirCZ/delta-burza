<?php

use App\Http\Controllers\EnterEventController;
use App\Http\Livewire\ListExhibitions;
use App\Http\Livewire\ShowExhibition;
use App\Http\Livewire\ShowRegistration;
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

Route::get('/', 'App\Http\Controllers\WelcomeController');

Route::get('/vystavy', ListExhibitions::class);
Route::get('/vystava/{exhibition}', ShowExhibition::class);
Route::get('/vstoupit/{time}/{registration}', EnterEventController::class);
Route::get('/registrace/{registration}', ShowRegistration::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');
