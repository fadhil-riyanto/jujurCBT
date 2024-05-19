<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models;

class SoalRepository {
    public function __construct(
        protected Models\SoalModel $soal_db 
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
}