<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class KerjakanConfirm extends Controller
{
    protected $kode_mapel, $penugasan_id, $nomor_ujian;

    public function __construct(
        protected Repositories\PenyelesaianRepository $penyelesaian_repo,
        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pg_repo,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay_repo,
        protected Repositories\SoalRepository $soal_repo,
        
        // 
        
    ) {} 

    private function get_filled() {
        $pg = count($this->on_runtime_pg_repo->get_all_answer_by_siswa_and_penugasan(
            $this->nomor_ujian, $this->kode_mapel, $this->penugasan_id
        ));

        $essay = count($this->on_runtime_essay_repo->get_all_answer_by_siswa_and_penugasan(
            $this->nomor_ujian, $this->kode_mapel, $this->penugasan_id
        ));

        // dd($pg);

        return [$pg, $essay]; // pg, essay
    }

    private function get_total() {
        return $this->soal_repo->get_total_soal($this->kode_mapel);
    }

    private function get_unfilled_total($total_soal, $total_filled_count) { // total_filled_count = pg + essay
        
        return $total_soal - $total_filled_count;
    }

    // get filled and unfilled data
    public function Index($kode_mapel_n_penugasan_id, $nomor_ujian, Request $request) {
        $exp = explode('-', $kode_mapel_n_penugasan_id);
        $this->kode_mapel = $exp[0];
        $this->penugasan_id = $exp[1];
        $this->nomor_ujian = $nomor_ujian;

        [$pg, $essay] = $this->get_filled();
        // dd($this->get_unfilled_total($pg + $essay));
        $total_soal = $this->get_total();

        $retarr = [
            "kode_mapel" => explode('-', $kode_mapel_n_penugasan_id)[0], 
            "penugasan_id" => explode('-', $kode_mapel_n_penugasan_id)[1],
            'nomor_ujian' => $nomor_ujian,
            'details' => [
                "jawaban_pg_terisi" => $pg,
                "jawaban_essay_terisi" => $essay,
                "belum_disi" => $this->get_unfilled_total($total_soal, $pg + $essay),
                "total_soal" => $total_soal
            ]
        ];

        // dd($retarr);
        
        return view("views/kerjakan_confirm", $retarr);
    }
}
