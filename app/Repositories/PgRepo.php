<?php

namespace App\Repositories;

use App\Models;

class PgRepo
{
    public function __construct(
        protected Models\PilihanGandaModel $pg_model
    ) {}

    public function get_option_ordered($kode_mapel, $id_soal) {
        return $this->pg_model->where("mata_pelajaran", "=", $kode_mapel)
            ->where("nomor_soal", "=", $id_soal)
            ->get();
    }
}