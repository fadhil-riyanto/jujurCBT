<?php

use Illuminate\Support\Facades\Route;
use App\Http;
use App\Http\Middleware;

Route::prefix("/api")->group(function() {
    // global
    Route::post("/auth", [Http\Controllers\LoginController::class, "login"]);
    

    // only for student
    Route::prefix("/dashboard")->group(function() {
        Route::get("/get_mata_pelajaran", [Http\Controllers\GetMataPelajaranController::class, "GetData"]);
        Route::post("/get_me", [Http\Controllers\GetMeController::class, "getData"]);
    })->middleware(Middleware\EnsureUsersOnStudent::class);
    
});

/* debug route */
Route::get('/debug', [Http\Controllers\CookiedebugController::class, "debug"]);

/* route for web */

Route::get('/admin', function () {
    return view("views/admin");
})->middleware(Middleware\EnsureUsersOnAdmin::class);

Route::get('/dashboard', function () {
    return view("views/dashboard");
})->middleware(Middleware\EnsureUsersOnStudent::class);

Route::get('/login', function () {
    return view("views/login");
});

Route::get('/', [Http\Controllers\IndexController::class, "IndexController"]);