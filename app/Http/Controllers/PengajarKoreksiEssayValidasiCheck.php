<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class PengajarKoreksiEssayValidasiCheck extends Controller
{
    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_repo,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay,
        protected Repositories\SoalRepository $soal_repo
    ) {}

    private function return_ids($kode_mapel) : Iterable {
        foreach($this->soal_repo->get_ordered_list_id($kode_mapel)->toArray() as $id) {
            yield $id["id"];
        }
    }

    private function return_soal_and_answers($kode_mapel) : Iterable {
        foreach ($this->soal_repo->get_ordered_list_id_essay($kode_mapel) as $id) {
            yield [
                "id_soal" => $id["id"],
                "nomor_soal" => array_search($id["id"], iterator_to_array($this->return_ids($kode_mapel))) + 1,
                "soal" => $this->soal_repo->get_soal($kode_mapel, $id["id"]),
                "jawab" => $this->on_runtime_essay->get_answer_detail(
                    $this->nomor_ujian, $kode_mapel, $id["id"], $this->penugasan_id
                ),
                "points" => $this->on_runtime_essay->get_answer_very_detail(
                    $this->nomor_ujian, $kode_mapel, $id["id"], $this->penugasan_id
                )
                
            ];
        }
    }

    private function siswa_details($nomor_ujian) {
        return $this->siswa_repo->siswaDetails($nomor_ujian);
    }

    public function Index(Request $request) {
        $validated = $request->validate([         // convention list
            "kelas" => "required",
            "kode_mapel" => "required",
            "penugasan_id" => "required",
            "nomor_ujian" => "required"
        ]);

        $this->kelas = $request->kelas;
        $this->kode_mapel = $request->kode_mapel;
        $this->penugasan_id = $request->penugasan_id;
        $this->nomor_ujian = $request->nomor_ujian;

        $data = iterator_to_array($this->return_soal_and_answers($this->kode_mapel));

        // dd($data);
        return view("views/pengajar_koreksi_essay_validasi_check", [
            "data" => $data,
            "details" => $this->siswa_details($this->nomor_ujian),
            "preload_data" => [
                "kelas" => $this->kelas,
                "kode_mapel" => $this->kode_mapel,
                "penugasan_id" => $this->penugasan_id,
                "nomor_ujian" => $this->nomor_ujian
            ]
        ]);
    }
}
