<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;

class PengajarKoreksiSavePoints extends Controller
{
    public function __construct(
        protected Models\onRunTimeEssayModel $on_runtime_essay
    ){} 

    private function set_points(int $points) {
        return $this->on_runtime_essay
        ->where("mata_pelajaran", "=", $this->kode_mapel)
        ->where("penugasan_id", "=", $this->penugasan_id)
        ->where("nomor_ujian", "=", $this->nomor_ujian)
        ->where("id_soal", "=", $this->id_soal)
        ->update([
            "points" => $points
        ]);
        
    }

    public function Index(Request $request) {
        $validated = $request->validate([
            "kode_mapel" => "required",
            "penugasan_id" => "required",
            "nomor_ujian" => "required",
            "id_soal" => "required",
            "points" => "required"
        ]);

        $this->kode_mapel = $request->kode_mapel;
        $this->penugasan_id = $request->penugasan_id;
        $this->nomor_ujian = $request->nomor_ujian;
        $this->id_soal = $request->id_soal;

        return $this->set_points($request->points);
    }
}
