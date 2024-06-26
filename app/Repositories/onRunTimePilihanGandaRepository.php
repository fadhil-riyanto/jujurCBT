<?php

namespace App\Repositories;

use App\Models;
use Illuminate\Support\Facades\DB;

class onRunTimePilihanGandaRepository {
    public function __construct(
        protected Models\onRunTimePilihanGandaModel $on_runtime_pg_repo
    ){}


    /**
     * 0 for unanswered
     * 1 for answered
     * 
     * DEPRECATED WARN
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

    // get total answered of student
    public function get_total_answer($nomor_ujian, $penugasan_id) {
        return $this->on_runtime_pg_repo
            ->select(DB::raw("count(*) AS total"))
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("penugasan_id", "=", $penugasan_id)
            ->first();
    }

    /**
     * return false if not answered
     * return number of selected jawaban if answered
     */

    public function get_answer_detail($nomor_ujian, $kode_mapel, $id_soal, $penugasan_id)  {
        $query = $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("id_soal", "=", $id_soal)
            ->where("penugasan_id", "=", $penugasan_id)
            
            ->first();
        if ($query != null) {
            return $query["index_jawaban"];
        } else {
            return false;
        }
    }

    // under testing (deprecated warn)
    public function get_all_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->get();
    }

    // by penugasan id
    public function get_all_answer_by_siswa_and_penugasan($nomor_ujian, $kode_mapel, $penugasan_id) {
        return $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("penugasan_id", "=", $penugasan_id)
            ->get();
    }

    // used as determine status on dashboatd
    public function get_fixed_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_pg_repo
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("is_fixed", "=", 1) // turned to 1 when student has been submit the exam
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

    public function insert_siswa_selection($mata_pelajaran, $nomor_ujian, $id_soal, $id_jawaban, $penugasan_id) {
        $this->on_runtime_pg_repo->updateOrInsert(
            [
                "mata_pelajaran" => $mata_pelajaran,
                "nomor_ujian" => $nomor_ujian,
                "id_soal" => $id_soal,
                "penugasan_id" => $penugasan_id
            ],
            [
                "index_jawaban" => $id_jawaban
            ]
        );
    }

    public function change2fixed($mata_pelajaran, $nomor_ujian) {
        $this->on_runtime_pg_repo
            ->where("mata_pelajaran", "=", $mata_pelajaran)
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->update([
                "is_fixed" => 1
            ]);

    }

}
