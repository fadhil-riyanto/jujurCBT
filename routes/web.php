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

    // Route::prefix("/pengajar")->group(function() {
    //     Route::get("/get_nilai_by_penugasan", [Http\Controllers\PengajarNilaiCheck::class, "Api"])
    //     ->middleware(Middleware\EnsureUsersOnPengajar::class);
    // });

    // store_pilihan_ganda
    Route::prefix("/kerjakan")->group(function() {
        Route::post("/store_pg", [Http\Controllers\JawabanStore::class, "store_pilihan_ganda"])
            ->middleware(Middleware\EnsureUsersOnStudent::class);

            //
        Route::post("/store_essay", [Http\Controllers\JawabanStore::class, "store_essay"])
            ->middleware(Middleware\EnsureUsersOnStudent::class);

        // 
        Route::post("/confirm_exam", [Http\Controllers\JawabanStore::class, "confirm_exam"])
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

        Route::resource("pengajar", Http\Controllers\AdminPengajarController::class)->only([
            'create', 'index', 'store', 'update', 'destroy', 'edit'
        ])->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/create_mapel", [Http\Controllers\DaftarMataPelajaranController::class, "Create"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/getall_mapel", [Http\Controllers\DaftarMataPelajaranController::class, "Index"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/get_mapel_info/{kode_soal}", [Http\Controllers\DaftarMataPelajaranController::class, "get_mapel_info"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/remove_mapel", [Http\Controllers\DaftarMataPelajaranController::class, "Delete"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::post("/set_mapel_config/{kode_mapel}", [Http\Controllers\DaftarMataPelajaranController::class, "set_mapel_config"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::get("/get_all_available_kelas", [Http\Controllers\AdminGetAllAvailableKelasController::class, "getData"])
        ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

        Route::prefix("soal")->group(function() {
            Route::get("store_soal_jawaban/{kode_mapel}/{id_soal}", [Http\Controllers\AdminSoalEditorController::class, "store_soal_jawaban"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::post("store_upload_image/{kode_mapel}/{id_soal}", [Http\Controllers\AdminSoalEditorController::class, "store_upload_image"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::post("hapus_upload_image/{kode_mapel}/{id_soal}", [Http\Controllers\AdminSoalEditorController::class, "hapus_upload_image"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::get("get_upload_image/{str}", [Http\Controllers\AdminSoalEditorController::class, "get_upload_image"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::get("get_soal_details/{kode_mapel}/{id_soal}", [Http\Controllers\AdminSoalEditorController::class, "get_soal_details"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::get("get_soal_options/{kode_mapel}/{id_soal}", [Http\Controllers\AdminSoalEditorController::class, "get_soal_options"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::get("get_total_soal_with_ids/{kode_mapel}", [Http\Controllers\AdminSoalEditorController::class, "get_total_soal_with_ids"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::get("delete_soal/{kode_mapel}/{id_soal}", [Http\Controllers\AdminSoalEditorController::class, "delete_soal"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::post("create/{kode_mapel}", [Http\Controllers\AdminSoalEditorController::class, "create_new_soal"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
        });

        Route::prefix("penugasan")->group(function() {
            Route::get("store", [Http\Controllers\AdminPenugasan::class, "store"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
            
            Route::get("getall", [Http\Controllers\AdminPenugasan::class, "getAll"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

            Route::get("delete/{id}", [Http\Controllers\AdminPenugasan::class, "delete"])
                ->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
        });
    });
    
});

/* debug route */
Route::get('/debug', [Http\Controllers\CookiedebugController::class, "debug"]);

/* route for web */

Route::prefix("/admin")->group(function() {
    // Route::get('/welcome', function () {
    //     return view("views/admin_welcome");
    // })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
    Route::get('/welcome', [Http\Controllers\AdminWelcomeController::class, "index"]);

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

    // additional page, not showed in sidebar
    Route::get('/edit_soal', function () {
        return view("views/admin_edit_soal");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);

    Route::get('/edit_soal_setting', function () {
        return view("views/admin_edit_soal_setting");
    })->middleware(Middleware\EnsureUsersOnSuperAdmin::class);
});


Route::get('/pengajar', fn() => view("views/pengajar_welcome") );
Route::get('/pengajar/nilai', [Http\Controllers\PengajarNilaiController::class, "Index"]);
Route::get('/pengajar/nilai/check', [Http\Controllers\PengajarNilaiCheck::class, "Index"]);
// [Http\Controllers\PengajarNilaiCheck::class, "Datatable"]
// ->middleware(Middleware\EnsureUsersOnPengajar::class)

Route::get('/dashboard', [Http\Controllers\DashboardController::class, "index"])
    ->middleware(Middleware\EnsureUsersOnStudent::class);

Route::get('/kerjakan/{kode_mapel}/{id?}', [Http\Controllers\KerjakanController::class, "Index"]);

Route::get('/confirm/{kode_mapel_n_penugasan_id}/{nomor_ujian}', [Http\Controllers\KerjakanConfirm::class, "Index"]);

// function () {
//     return view("views/kerjakan");
// });

Route::get('/login', function () {
    return view("views/login");
});

Route::get('/', [Http\Controllers\IndexController::class, "IndexController"]);

// all can access
Route::get('/blokir', function () {
    return view("errors/blokir");
});


Route::get('/logout', [App\Http\Controllers\LogoutController::class, "Index"]);

