<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteSpecialization;
use App\Http\Controllers\EnterEventController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Livewire\AddSchool;
use App\Http\Livewire\CreateCompany;
use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\CreateRegistration;
use App\Http\Livewire\CreateSchool;
use App\Http\Livewire\EditCompany;
use App\Http\Livewire\EditRegistration;
use App\Http\Livewire\EditSchool;
use App\Http\Livewire\EditSpecialization;
use App\Http\Livewire\FilterSchools;
use App\Http\Livewire\InfoProStredniSkoly;
use App\Http\Livewire\InfoProZakyZS;
use App\Http\Livewire\ListExhibitions;
use App\Http\Livewire\ListExhibitionsRegion;
use App\Http\Livewire\PayOrder;
use App\Http\Livewire\ProcessPayments;
use App\Http\Livewire\ShowExhibition;
use App\Http\Livewire\ShowOrder;
use App\Http\Livewire\ShowSchool;
use App\Http\Livewire\ShowSpecialization;
use App\Http\Livewire\CreateSpecialization;
use App\Http\Livewire\TermsOfUse;
use App\Http\Livewire\InfoAbout;
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
Route::get("/obchodni_podminky", TermsOfUse::class)->name("obchodni_podminky");
Route::get('/o-nas', InfoAbout::class)->name("o_nas");

Route::get('/vystavy', ListExhibitions::class)->name("vystavy");
Route::get('/vystavy/{region}', ListExhibitionsRegion::class);
Route::get('/vystava/{exhibition}', ShowExhibition::class);
Route::get('/vstoupit/{time}/{registration}', EnterEventController::class);

Route::get("/skola/filtrovat", FilterSchools::class);


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/obor/vytvorit', CreateSpecialization::class);
    Route::get('/obor/{specialization}/upravit', EditSpecialization::class);
    Route::delete('/obor/{specialization}/smazat', DeleteSpecialization::class);

    Route::get('/objednavka/vytvorit', CreateOrder::class);

    Route::get('/registrace/vytvorit', CreateRegistration::class);
    Route::get('/registrace/{registration}/upravit', EditRegistration::class);

    Route::get("/objednavka/{order}/zaplatit", PayOrder::class);
    Route::get("/objednavka/{order}", ShowOrder::class);
//    Route::get("/faktura/{order}", InvoiceController::class);

    Route::get('/skola/vytvorit', CreateSchool::class);
    Route::get('/spolecnost/vytvorit', CreateCompany::class);

    Route::get('/skola/upravit', EditSchool::class);
    Route::get('/spolecnost/upravit', EditCompany::class);

    Route::get('/spolecnost/skola/pridat', AddSchool::class);

    Route::get("/platby/import", ProcessPayments::class);

    Route::post("/obrazek/nahrat", "App\Http\Controllers\ImageController@nahrat");
    Route::delete("/obrazek/{file}/smazat", "App\Http\Controllers\ImageController@smazat");
});

Route::get('/skola/{school}', ShowSchool::class);
Route::get('/obor/{specialization}', ShowSpecialization::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', DashboardController::class)->name('dashboard');

