<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/categories",[CategoryController::class,"index"])->name("categories.index");
Route::get("/category/options",[CategoryController::class,"options"])->name("categories.options");
Route::post("/categories",[CategoryController::class,"store"])->name("categories.store");
Route::delete("/categories/{id}",[CategoryController::class,"destroy"])->name("categories.destroy");
Route::put("/categories/{id}",[CategoryController::class,"update"])->name("categories.update");

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
