<?php

namespace App\Repositories;
use App\Models;
use Illuminate\Support\Facades\DB;

class PenugasanRepository {

    // load some model
    public function __construct(
        protected Models\KelasModel $kelas_model,
        protected Models\DaftarMataPelajaranModel $daftar_mata_pelajaran_model,
        protected Models\PenugasanModel $penugasan_model
    ){}

    public function insertPenugasan($arr) {

        // dd($arr);
        $this->penugasan_model::insert([
            "kelas_id" => $arr->kelas, 
            "kode_mapel" => $arr->kode_mapel,
            "start_date" => $arr->start_date, 
            "start_time" => $arr->start_time,
            "duration_time" => $arr->duration_time,
            "unix" => $arr->unix
        ]);
    }

    public function set_bobot_nilai_essay($penugasan_id, $bobot) {
        return $this->penugasan_model
            ->where("id", "=", $penugasan_id)
            ->update(["bobot_essay" => $bobot]);
    }

    public function get_bobot_nilai_essay($penugasan_id) {
        $data = $this->penugasan_model
        ->where("id", "=", $penugasan_id)
        ->first();

        return  $data == null ? null : $data["bobot_essay"];
    }

    public function get_penugasan_by_kelas($kelas_id) {
        return $this->penugasan_model->where("kelas_id", "=", $kelas_id)->get();
    }

    public function get_penugasan_by_kode_mapel($kode_mapel) {
        return $this->penugasan_model->where("kode_mapel", "=", $kode_mapel)->get();
    }

    public function get_penugasan_detail_by_penugasan_id($penugasan_id) {
        return $this->penugasan_model->where("id", "=", $penugasan_id)->first();
    }

    public function is_exist_penugasan_by_kelas_and_mapel($kelas_id, $kode_mapel) {
        return $this->penugasan_model->select(DB::raw("count(1) AS result"))
            ->where("kelas_id", "=", $kelas_id)
            ->where("kode_mapel", "=", $kode_mapel)
            ->first()["result"] ? true : false;
    }

    public function is_exist_penugasan_by_kelas_and_mapel_and_id($kelas_id, $kode_mapel, $penugasan_id) {
        return $this->penugasan_model->select(DB::raw("count(1) AS result"))
            ->where("id", "=", $penugasan_id)
            ->where("kelas_id", "=", $kelas_id)
            ->where("kode_mapel", "=", $kode_mapel)
            ->first()["result"] ? true : false;
    }
    
    public function getAll() {
        return $this->penugasan_model::all();
    }

    public function remove($id) {
        return $this->penugasan_model->where("id", "=", $id)
            ->delete();
    }
}