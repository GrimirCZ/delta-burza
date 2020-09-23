<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnterEventController;
use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\CreateRegistration;
use App\Http\Livewire\CreateSchool;
use App\Http\Livewire\EditRegistration;
use App\Http\Livewire\EditSchool;
use App\Http\Livewire\EditSpecialization;
use App\Http\Livewire\InfoProStredniSkoly;
use App\Http\Livewire\InfoProZakyZS;
use App\Http\Livewire\ListExhibitions;
use App\Http\Livewire\ShowExhibition;
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

Route::get("/info_pro_stredni_skoly", InfoProStredniSkoly::class)->name("info_ss");
Route::get("/info_pro_zaky_zs", InfoProZakyZS::class)->name("info_zs");

Route::get('/vystavy', ListExhibitions::class);
Route::get('/vystava/{exhibition}', ShowExhibition::class);
Route::get('/vstoupit/{time}/{registration}', EnterEventController::class);
Route::get('/obor/{specialization}/upravit', EditSpecialization::class);
Route::get('/obor/{specialization}', ShowSpecialization::class);
Route::get('/obor/vytvorit', CreateSpecialization::class);

Route::get('/objednavka/vytvorit/{school}', CreateOrder::class);

Route::get('/registrace/vytvorit', CreateRegistration::class);
Route::get('/registrace/{registration}/upravit', EditRegistration::class);

Route::get('/skola/vytvorit', CreateSchool::class);

Route::get('/skola/upravit', EditSchool::class);
Route::get('/skola/{school}', ShowSchool::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', DashboardController::class)->name('dashboard');

