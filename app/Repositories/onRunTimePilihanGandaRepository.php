<?php

namespace App\Repositories;

use App\Models;

class onRunTimePilihanGandaRepository {
    public function __construct(
        protected Models\onRunTimePilihanGandaModel $on_runtime_pg_repo
    ){}

    /**
     * 0 for unanswered
     * 1 for answered
     */
    public function get_answer_status($nomor_ujian, $kode_mapel, $id_soal): bool {
        $query = $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("id_soal", "=", $id_soal)
            ->first();
        if ($query != null) {
            return ($query["state"] == null || $query["state"] == 0) ? false : true;
        } else {
            return false;
        }
    }

    // under testing
    public function get_all_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->get();
    }
    
    /*
     * when on click submit exam is occur, is fixed is changed to true, so its become confirmed
     */
    public function get_all_unconfirmed_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("is_fixed", "=", false)
            ->get();
    }

    /*
     * used as condition when user already pass the exam, the counter must be same as total soal,
     * in other words, the student must be answer all questions :)
     */
    public function get_all_confirmed_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("is_fixed", "=", true)
            ->get();
    }

}
