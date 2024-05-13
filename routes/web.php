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
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/add_siswa", [Http\Controllers\AdminAddSiswaController::class, "Add"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/add_kelas", [Http\Controllers\AdminAddKelasController::class, "Add"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/block_siswa", [Http\Controllers\AdminSiswaBlock::class, "doBlock"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/unblock_siswa", [Http\Controllers\AdminSiswaUnblock::class, "doUnblock"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/change_password_siswa", [Http\Controllers\AdminSiswaChangePassword::class, "Change"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/change_nama_siswa", [Http\Controllers\AdminSiswaChangeNama::class, "Change"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/delete_siswa", [Http\Controllers\AdminSiswaDelete::class, "Delete"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/remove_kelas", [Http\Controllers\AdminRemoveKelasController::class, "Remove"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::resource("pengajar", Http\Controllers\PengajarController::class)->only([
            'create', 'index', 'store', 'update', 'destroy', 'edit'
        ])->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/create_mapel", [Http\Controllers\DaftarMataPelajaranController::class, "Create"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/getall_mapel", [Http\Controllers\DaftarMataPelajaranController::class, "Index"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/remove_mapel", [Http\Controllers\DaftarMataPelajaranController::class, "Delete"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/get_all_available_kelas", [Http\Controllers\AdminGetAllAvailableKelasController::class, "getData"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
    });
    
});

/* debug route */
Route::get('/debug', [Http\Controllers\CookiedebugController::class, "debug"]);

/* route for web */

Route::prefix("/admin")->group(function() {
    Route::get('/welcome', function () {
        return view("views/admin_welcome");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/peserta_assesmen', function () {
        return view("views/admin_peserta_assesmen");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/manajemen_kelas', function () {
        return view("views/admin_manajemen_kelas");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/atur_pengajar', function () {
        return view("views/admin_atur_pengajar");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/soal_assesmen', function () {
        return view("views/admin_soal_assesmen");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/penugasan', function () {
        return view("views/admin_penugasan");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/nilai', function () {
        return view("views/admin_nilai");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
});


Route::get('/pengajar', function () {
    return view("views/pengajar");
});
// ->middleware(Middleware\EnsureUsersOnPengajar::class)

Route::get('/dashboard', function () {
    return view("views/dashboard");
})->middleware(Middleware\EnsureUsersOnStudent::class);

Route::get('/login', function () {
    return view("views/login");
});

Route::get('/', [Http\Controllers\IndexController::class, "IndexController"]);

// all can access
Route::get('/blokir', function () {
    return view("errors/blokir");
});

