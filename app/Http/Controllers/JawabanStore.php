<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;

class JawabanStore extends Controller
{
    public function __construct(
        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pg_repo,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay_repo
        
        // 
    ){}

    public function store_pilihan_ganda(Request $request) {
        $validated = $request->validate([         // convention list
            "kode_mapel" => "required",           // mata_pelajaran
            "nomor_ujian" => "required",          // nomor_ujian
            "id_soal" => "required",              // id_soal
            "id_jawaban" => "required"            // index_jawaban
        ]);

        $this->on_runtime_pg_repo->insert_siswa_selection(
            $request->kode_mapel, 
            $request->nomor_ujian,
            $request->id_soal,
            $request->id_jawaban
        );
    }

    // note is correct itu sebagai realtime data bagi akun pengampu
    // is fixed diubah jadi true semua kalau siswa sudah menyelesaikan ujian / waktu habis
    
    // hapus column state

    public function store_essay(Request $request) {
        $validated = $request->validate([         // convention list
            "kode_mapel" => "required",           // mata_pelajaran
            "nomor_ujian" => "required",          // nomor_ujian
            "id_soal" => "required",              // id_soal
            "jawaban_txt" => "required"            // index_jawaban
        ]);

        $this->on_runtime_essay_repo->insert_siswa_essay(
            $request->kode_mapel, 
            $request->nomor_ujian,
            $request->id_soal,
            $request->jawaban_txt
        );
    }

    public function confirm_exam(Request $request) {
        $validated = $request->validate([         // convention list
            "kode_mapel" => "required",           // mata_pelajaran
            "nomor_ujian" => "required"           // nomor_ujian
        ]);

        $this->on_runtime_pg_repo->change2fixed($request->kode_mapel, $request->nomor_ujian);
        $this->on_runtime_essay_repo->change2fixed($request->kode_mapel, $request->nomor_ujian);
    }

    // hapus state column
    // rename index_jawaban ke id_soal
    // ubah jawaban _txt ke text()
}
