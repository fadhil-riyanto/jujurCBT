<?php

use Illuminate\Support\Facades\Route;
use App\Http;
use App\Http\Middleware;

Route::prefix("/api")->group(function() {
    // global
    Route::post("/auth", [Http\Controllers\AuthController::class, "login"]);
    
    //both
    Route::prefix("/global")->group(function() {
        Route::get("/get_me", [Http\Controllers\GetMeController::class, "getData"])
        ->middleware(Middleware\EnsureNotAnonymousUser::class);
    });

    // only for student
    Route::prefix("/dashboard")->group(function() {
        Route::get("/get_mata_pelajaran", [Http\Controllers\GetMataPelajaranController::class, "GetData"])
        ->middleware(Middleware\EnsureUsersOnStudent::class);
        
    });

    // only for admin endpoint
    Route::prefix("/admin")->group(function() {
        Route::get("/get_siswa_by_kelas", [Http\Controllers\AdminGetSiswaByKelasController::class, "getData"])
        ->middleware(Middleware\EnsureUsersOnAdmin::class);

        Route::post("/add_siswa", [Http\Controllers\AdminAddSiswaController::class, "Add"])
        ->middleware(Middleware\EnsureUsersOnAdmin::class);

        Route::post("/add_kelas", [Http\Controllers\AdminAddKelasController::class, "Add"])
        ->middleware(Middleware\EnsureUsersOnAdmin::class);

        Route::post("/remove_kelas", [Http\Controllers\AdminRemoveKelasController::class, "Remove"])
        ->middleware(Middleware\EnsureUsersOnAdmin::class);

        Route::get("/get_all_available_kelas", [Http\Controllers\AdminGetAllAvailableKelasController::class, "getData"])
        ->middleware(Middleware\EnsureUsersOnAdmin::class);
    });
    
});

/* debug route */
Route::get('/debug', [Http\Controllers\CookiedebugController::class, "debug"]);

/* route for web */

Route::prefix("/admin")->group(function() {
    Route::get('/welcome', function () {
        return view("views/admin_welcome");
    })->middleware(Middleware\EnsureUsersOnAdmin::class);

    Route::get('/peserta_assesmen', function () {
        return view("views/admin_peserta_assesmen");
    })->middleware(Middleware\EnsureUsersOnAdmin::class);

    Route::get('/manajemen_kelas', function () {
        return view("views/admin_manajemen_kelas");
    })->middleware(Middleware\EnsureUsersOnAdmin::class);

    Route::get('/soal_assesmen', function () {
        return view("views/admin_soal_assesmen");
    })->middleware(Middleware\EnsureUsersOnAdmin::class);

    Route::get('/penugasan', function () {
        return view("views/admin_penugasan");
    })->middleware(Middleware\EnsureUsersOnAdmin::class);

    Route::get('/nilai', function () {
        return view("views/admin_nilai");
    })->middleware(Middleware\EnsureUsersOnAdmin::class);
});



Route::get('/dashboard', function () {
    return view("views/dashboard");
})->middleware(Middleware\EnsureUsersOnStudent::class);

Route::get('/login', function () {
    return view("views/login");
});

Route::get('/', [Http\Controllers\IndexController::class, "IndexController"]);
