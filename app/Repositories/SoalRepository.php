<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models;

class SoalRepository {
    public function __construct(
        public Models\SoalModel $soal_db 
    ){}
    
    /**
     * get total
     * 
     * @return int
     */
    public function get_total_soal($kode_mapel) : int {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->select(DB::raw("COUNT(*) as total_soal"))
            ->first()["total_soal"];
    }

    public function get_total_soal_pilgan($kode_mapel) : int {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
        ->where("tipe_soal", "=", "pilihan_ganda")
        ->select(DB::raw("COUNT(*) as total_soal"))
        ->first()["total_soal"];
    }

    public function get_total_soal_essay($kode_mapel) : int {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->where("tipe_soal", "=", "essay")
            ->select(DB::raw("COUNT(*) as total_soal"))
            ->first()["total_soal"];
    }
    

    public function get_soal($kode_mapel, $id) {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->where("id", "=", $id)
            ->first();
    }

    public function soal_typeof($kode_mapel, $id) {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->where("id", "=", $id)
            ->first()["tipe_soal"];
    }

    public function get_ordered_list_id($kode_mapel) {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->select("id")
            ->get();
    }

    public function get_ordered_list_id_pilgan($kode_mapel) {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->where("tipe_soal", "=", "pilihan_ganda")
            ->select("id")
            ->get();
    }

    public function get_ordered_list_id_essay($kode_mapel) {
        return $this->soal_db->where("mata_pelajaran", "=", $kode_mapel)
            ->where("tipe_soal", "=", "essay")
            ->select("id")
            ->get();
    }

    public function hasEssay($kode_mapel) {
        return $this->soal_db
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("tipe_soal", "=", "essay")
            ->select(DB::raw("COUNT(*) as total_soal"))
            ->first()["total_soal"] == 0 ? false : true;
    }

    public function hasPilgan($kode_mapel) {
        return $this->soal_db
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("tipe_soal", "=", "pilihan_ganda")
            ->select(DB::raw("COUNT(*) as total_soal"))
            ->first()["total_soal"] == 0 ? false : true;
    }
}