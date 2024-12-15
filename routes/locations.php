<?php
use App\Http\Controllers\locations\CountriesController;
use App\Http\Controllers\locations\DistrictsController;
use App\Http\Controllers\locations\StateController;
use App\Http\Controllers\locations\SubDistrictsController;
use Illuminate\Support\Facades\Route;


Route::prefix('/locations')->group(function () {
    Route::controller(CountriesController::class)->group(function () {
        Route::get('/countries', 'view')->name("admin.countries")->middleware(['permission:read']);
        Route::post('/countries/action', 'action')->name("admin.countriesAction");
    });
    Route::controller(StateController::class)->group(function () {
        Route::get('/states', 'view')->name("admin.states")->middleware(['permission:read']);
        Route::post('/states/action', 'action')->name("admin.statesAction");
        Route::post('/states/fetch', 'statesFetch')->name("admin.statesFetch");
    });
    Route::controller(DistrictsController::class)->group(function () {
        Route::get('/districts', 'view')->name("admin.districts")->middleware(['permission:read']);
        Route::post('/districts/action', 'action')->name("admin.districtsAction");
        Route::post('/districts/fetch', 'districtsFetch')->name("admin.districtsFetch");
    });
    Route::controller(SubDistrictsController::class)->group(function () {
        Route::get('/sub-districts', 'view')->name("admin.SubDistricts")->middleware(['permission:read']);
        Route::post('/sub-districts/action', 'action')->name("admin.subDistrictsAction");
        Route::post('/sub-districts/fetch', 'subDistrictsFetch')->name("admin.subDistrictsFetch");
    });
});


