<?php

namespace App\Repositories;

use App\Models;

class onRunTimeEssayRepository {
    public function __construct(
        protected Models\onRunTimeEssayModel $on_runtime_essay
    ){}

    /**
     * 0 for unanswered
     * 1 for answered
     * 
     * DEPRECATED WARN
     */
    // public function get_answer_status($nomor_ujian, $kode_mapel, $id_soal): bool {
    //     $query = $this->on_runtime_pg_repo
    //         ->where("nomor_ujian", "=", $nomor_ujian)
    //         ->where("mata_pelajaran", "=", $kode_mapel)
    //         ->where("id_soal", "=", $id_soal)
    //         ->first();
    //     if ($query != null) {
    //         return ($query["state"] == null || $query["state"] == 0) ? false : true;
    //     } else {
    //         return false;
    //     }
    // }

    // /**
    //  * return false if not answered
    //  * return number of selected jawaban if answered
    //  */

    public function get_answer_detail($nomor_ujian, $kode_mapel, $id_soal)  {
        $query = $this->on_runtime_essay
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("id_soal", "=", $id_soal)
            ->first();
        if ($query != null) {
            return $query["jawaban_txt"];
        } else {
            return false;
        }
    }

    // // under testing
    public function get_all_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_essay
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->get();
    }

     // used as determine status on dashboatd
     public function get_fixed_answer_by_siswa($nomor_ujian, $kode_mapel) {
        return $this->on_runtime_essay
            ->where("nomor_ujian", "=", $nomor_ujian)
            ->where("mata_pelajaran", "=", $kode_mapel)
            ->where("is_fixed", "=", 1) // turned to 1 when student has been submit the exam
            ->get();
    }
    
    // /*
    //  * when on click submit exam is occur, is fixed is changed to true, so its become confirmed
    //  */
    // public function get_all_unconfirmed_answer_by_siswa($nomor_ujian, $kode_mapel) {
    //     return $this->on_runtime_pg_repo
    //         ->where("nomor_ujian", "=", $nomor_ujian)
    //         ->where("mata_pelajaran", "=", $kode_mapel)
    //         ->where("is_fixed", "=", false)
    //         ->get();
    // }

    // /*
    //  * used as condition when user already pass the exam, the counter must be same as total soal,
    //  * in other words, the student must be answer all questions :)
    //  */
    // public function get_all_confirmed_answer_by_siswa($nomor_ujian, $kode_mapel) {
    //     return $this->on_runtime_pg_repo
    //         ->where("nomor_ujian", "=", $nomor_ujian)
    //         ->where("mata_pelajaran", "=", $kode_mapel)
    //         ->where("is_fixed", "=", true)
    //         ->get();
    // }

    // public function insert_siswa_selection($mata_pelajaran, $nomor_ujian, $id_soal, $id_jawaban) {
    //     $this->on_runtime_pg_repo->updateOrInsert(
    //         [
    //             "mata_pelajaran" => $mata_pelajaran,
    //             "nomor_ujian" => $nomor_ujian,
    //             "id_soal" => $id_soal
    //         ],
    //         [
    //             "index_jawaban" => $id_jawaban
    //         ]
    //     );
    // }

    public function insert_siswa_essay($mata_pelajaran, $nomor_ujian, $id_soal, $jawaban_txt) {
        $this->on_runtime_essay->updateOrInsert(
            [
                "mata_pelajaran" => $mata_pelajaran,
                "nomor_ujian" => $nomor_ujian,
                "id_soal" => $id_soal
            ],
            [
                "jawaban_txt" => $jawaban_txt
            ]
        );
    }

}
