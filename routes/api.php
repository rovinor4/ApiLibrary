<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookShelvesController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware("guest")->group(function () {
    Route::post("login", [AuthController::class, "Login"]);
    Route::post("register", [AuthController::class, "Register"]);
});


Route::middleware("auth:sanctum")->group(function () {
    Route::post("logout", [AuthController::class, "Logout"]);
    Route::post("logout-all", [AuthController::class, "LogoutAll"]);


    Route::middleware("role.admin")->group(function () {
        Route::apiResource("book-shelves", BookShelvesController::class);
    });
});
