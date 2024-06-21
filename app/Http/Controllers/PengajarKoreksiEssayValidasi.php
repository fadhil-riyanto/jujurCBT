<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class PengajarKoreksiEssayValidasi extends Controller
{
    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_repo,

        // protected Repositories\PenyelesaianRepository $penyelesaian_repo,
        // protected Repositories\SoalRepository $soal_repo,
        protected Repositories\PenugasanRepository $penugasan_repo,

        // protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pilgan,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay,
        protected Repositories\PenyelesaianRepository $penyelesaian_repo
        
        
        // 
    ) {}

    private function is_done($nomor_ujian) {
        $ctx = $this->penugasan_repo->get_penugasan_detail_by_penugasan_id($this->penugasan_id);

        if (time() > add_unix_mins($ctx["unix"], $ctx["duration_time"])) {
            return true;
        }

        return $this->penyelesaian_repo->set($this->kode_mapel, $nomor_ujian, $this->penugasan_id)
            ->isFixed();
    }

    /**
     * logic: if all record points not null, its done
     */
    private function return_correction_status($nomor_ujian) { 
        if ($this->is_done($nomor_ujian)) {
            $datafrom_student_answer = $this->on_runtime_essay->get_all_answer_by_siswa_and_penugasan(
                $nomor_ujian, $this->kode_mapel, $this->penugasan_id
            );

            if (count($datafrom_student_answer) == 0) {
                return "-";
            } else {
                foreach($datafrom_student_answer as $datafrom_answer_s) {
                    if ($datafrom_answer_s["points"] == null) {
                        return "belum"; // not corrected yet
                    }
                }
            }
            
            return "ya";
        } else {
            return "belum selesai";
        }
        
    }

    private function return_status($nomor_ujian) { 
        if ($this->is_done($nomor_ujian)) {
            $datafrom_student_answer = $this->on_runtime_essay->get_all_answer_by_siswa_and_penugasan(
                $nomor_ujian, $this->kode_mapel, $this->penugasan_id
            );
            
            if (count($datafrom_student_answer) == 0) {
                return "selesai tapi tidak mengerjakan essay sama sekali";
            } 
            
            return "selesai mengerjakan";
        } else {
            return "belum mengerjakan";
        }
        
    }

    private function return_siswa_by_spesific_class() {
        return $this->siswa_repo->getByTable("kelas", $this->kelas)->get();
    }

    private function generate_aksi_btn_state($nomor_ujian) { // return true to disable
        if (!$this->is_done($nomor_ujian)) { // not done yet
            return true;
        } else {

        }
    }

    private function pack_data(): Iterable {
        
        foreach($this->return_siswa_by_spesific_class() as $data_s) {
            // $this->return_correction_status($data_s["nomor_ujian"]);
            if ($this->is_done($data_s["nomor_ujian"])) {
                yield [
                    "nama" => $data_s["nama"],
                    "terkoreksi" => $this->return_correction_status($data_s["nomor_ujian"]),
                    "status" => $this->return_status($data_s["nomor_ujian"]),
                    "aksi" => $this->return_correction_status($data_s["nomor_ujian"]),
                    "nomor_ujian" => $data_s["nomor_ujian"]
                ];
            }
            
        }
    }

    public function Index(Request $request) {
        $validated = $request->validate([         // convention list
            "kelas" => "required",
            "kode_mapel" => "required",
            "penugasan_id" => "required"
        ]);

        $this->kelas = $request->kelas;
        $this->penugasan_id = $request->penugasan_id;
        $this->kode_mapel = $request->kode_mapel;

        // dd($this->return_siswa_by_spesific_class());

        return view("views/pengajar_koreksi_essay_validasi", [
            "data" => iterator_to_array($this->pack_data()),
            "preload_data" => [
                "kelas" => $this->kelas,
                "penugasan_id" => $this->penugasan_id,
                "kode_mapel" => $this->kode_mapel
            ]
        ]);
    }
}
