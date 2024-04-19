<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DrinkController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["middleware"=>"auth:sanctum" ], function(){
    
    Route::post("/addDrink",[DrinkController::class,"addDrink"]);
    Route::put("/modDrink",[DrinkController::class,"modifyDrink"]);
    Route::delete("/delDrink",[DrinkController::class,"destroyDrink"]);
    
    Route::post("/typeExists",[TypeController::class,"tehereExistsTypeByName"]);
    Route::post("/addType",[TypeController::class,"addType"]);
    Route::put("/modType",[TypeController::class,"modifyType"]);
    Route::delete("/delType",[TypeController::class,"destroyType"]);
    
    Route::post("/packageExists",[PackageController::class,"tehereExistsPackageByName"]);
    Route::post("/addPackage",[PackageController::class,"addPackage"]);
    Route::put("/modPackage",[PackageController::class,"modifyPackage"]);
    Route::delete("/delPackage",[PackageController::class,"destroyPackage"]);
    
    Route::post("/logout",[AuthController::class,"logout"]);
});


Route::get("/getDrinks",[DrinkController::class,"getDrinks"]);
Route::post("/getDrink",[DrinkController::class,"getDrinkByNameReq"]);
Route::get("/getTypes",[TypeController::class,"getTypes"]);
Route::get("/getPackages",[PackageController::class,"getPackages"]);


Route::post("/register",[AuthController::class,"register"]);//->middleware("throttle:100,43200");
Route::post("/login",[AuthController::class,"login"]);//->middleware("throttle:100,43200");