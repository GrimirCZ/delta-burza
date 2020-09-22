<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnterEventController;
use App\Http\Livewire\CreateSchool;
use App\Http\Livewire\ListExhibitions;
use App\Http\Livewire\ShowExhibition;
use App\Http\Livewire\ShowRegistration;
use App\Http\Livewire\ShowSchool;
use App\Http\Livewire\ShowSpecialization;
use App\Http\Livewire\CreateSpecialization;
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
Route::get('/obor/{specialization}', ShowSpecialization::class);
Route::get('/obor/create/{school}', CreateSpecialization::class);


Route::get('/skola/vytvorit', CreateSchool::class);

Route::get('/skola/{school}', ShowSchool::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', DashboardController::class)->name('dashboard');

