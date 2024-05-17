<?php

namespace App\Repositories;
use App\Models;

class PenugasanRepository {

    // load some model
    public function __construct(
        protected Models\KelasModel $kelas_model,
        protected Models\DaftarMataPelajaranModel $daftar_mata_pelajaran_model,
        protected Models\PenugasanModel $penugasan_model
    ){}

    public function insertPenugasanOrCreate($arr) {

        // dd($arr);
        $this->penugasan_model::updateOrCreate([
            "kelas_id" => $arr->kelas, "kode_mapel" => $arr->kode_mapel
        ], [
            "start_date" => $arr->start_date, 
            "start_time" => $arr->start_time,
            "duration_time" => $arr->duration_time,
            "unix" => $arr->unix
        ]);
    }
    
    public function getAll() {
        return $this->penugasan_model::all();
    }

    public function remove($id) {
        return $this->penugasan_model->where("id", "=", $id)
            ->delete();
    }
}