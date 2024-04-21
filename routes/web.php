<?php

use Illuminate\Support\Facades\Route;
use App\Http;

Route::prefix("/api")->group(function() {
    Route::post("/auth", [Http\Controllers\LoginController::class, "login"]);

    Route::prefix("/dashboard")->group(function() {
        Route::get("/get_mata_pelajaran", [Http\Controllers\getMataPelajaran::class, "GetResult"]);
    });
    
});

Route::get('/login', function () {
    return view("views/login");
});


Route::get('/dashboard', function () {
    return view("views/dashboard");
});

// Route::get('/', [Http\Controllers\IndexController::class, "IndexController"]);