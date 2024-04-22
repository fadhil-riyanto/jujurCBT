<?php

use Illuminate\Support\Facades\Route;
use App\Http;

Route::prefix("/api")->group(function() {
    Route::post("/auth", [Http\Controllers\LoginController::class, "login"]);

    Route::prefix("/dashboard")->group(function() {
        Route::get("/get_mata_pelajaran", [Http\Controllers\GetMataPelajaranController::class, "GetResult"]);
        Route::get("/get_me", [Http\Controllers\GetMeController::class, "GetResult"]);
    });
    
});

Route::get('/admin', function () {
    return view("views/admin");
});

Route::get('/login', function () {
    return view("views/login");
});


Route::get('/debug', [Http\Controllers\CookiedebugController::class, "debug"]);


Route::get('/dashboard', function () {
    return view("views/dashboard");
});

Route::get('/', [Http\Controllers\IndexController::class, "IndexController"]);