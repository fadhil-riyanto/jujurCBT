<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::prefix("/api")->group(function() {
    Route::post("/auth", [LoginController::class, "login"]);
    Route::get("/token", function() {
        return csrf_token();
    });
});

Route::get("/test", function() {
    return view("test", [
        "nama" => "fadhil",
        "kelas" => "12 tkj 1"
    ]);
});


Route::get('/', function () {
    return view("index");
});
