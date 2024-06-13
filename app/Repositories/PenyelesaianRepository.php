<?php

namespace App\Repositories;

use App\Models;

class PenyelesaianRepository {
    protected $kode_mapel, $nomor_ujian, $penugasan_id;

    public function __construct(
        protected Models\PenyelesaianModel $penyelesaian_db
    ) {}

    public function set($kode_mapel, $nomor_ujian, $penugasan_id) {
        $this->kode_mapel = $kode_mapel;
        $this->nomor_ujian = $nomor_ujian;
        $this->penugasan_id = $penugasan_id;
        
        return $this;
    }

    public function setFixed() {
        $this->penyelesaian_db
            ->updateOrInsert([
                "kode_mapel" => $this->kode_mapel,
                "nomor_ujian" => $this->nomor_ujian,
                "penugasan_id" => $this->penugasan_id
            ], [
                "is_end" => 1
            ]);
    }

    public function isFixed() {
        $data = $this->penyelesaian_db
            ->where("kode_mapel", "=", $this->kode_mapel)
            ->where("nomor_ujian", "=", $this->nomor_ujian)
            ->where("penugasan_id", "=", $this->penugasan_id)
            ->first();

        return ($data == null) ? false : ($data["is_end"] == 1 ? true : false);
            
            // ->updateOrInsert([
            //     "kode_mapel" => $this->kode_mapel,
            //     "nomor_ujian" => $this->nomor_ujian,
            //     "penugasan_id" => $this->penugasan_id
            // ], [
            //     "is_end" => 1
            // ]);
    }

    public function deleteAllByPenugasanID($penugasan_id) {
        $this->penyelesaian_db->where("penugasan_id", "=", $penugasan_id)
            ->delete();
    }
}