<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Models;
use App\Repositories;

class DashboardController extends Controller
{
    use Traits\CurrentSessionTrait;
    public function __construct(
        protected Models\SiswaAccountModel $siswa_account_db,
        protected Models\PenugasanModel $penugasan_db,
        protected Repositories\DaftarMataPelajaranRepository $daftar_mapel_repo,
        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pg_repo,
        protected Repositories\SoalRepository $soal_repo
    ) {}

    // only r/ here

    private function get_current_class() :string {
        return $this->siswa_account_db->where("nomor_ujian", "=", $this->cookie_identity)
            ->first()["kelas"];
        // dd($kelas);
    }

    private function get_matched_penugasan_by_kelas($kelas) {
        $data = $this->penugasan_db->where("kelas_id", "=", $kelas)->get();

        return $data;
    }

    private function get_real_mapel_name($kode_mapel) : ?string {
       return $this->daftar_mapel_repo->get_mapel_info($kode_mapel)["nama_mata_pelajaran"];
    }

    private function status_dikerjakan($kode_mapel) : ?string {
        $data = count($this->on_runtime_pg_repo->get_all_answer_by_siswa(
            $this->cookie_identity, $kode_mapel
        ));

        $data_total_soal = $this->soal_repo->get_total_soal($kode_mapel);
        // dd($data_total_soal);

        // $fixed_exam_data = 
        // return match($data) {
        //     ($data >= 0) => "lanjutkan",
        //     ($data == 0) => "belum dikerjakan",
        //     ($data == $fixed_data) => "selesai",
        //     default => null
        // };
        // dd($fixed_data);
        if ($data == 0) {
            return "belum mengerjakan";
        } else if ($data > 0 && $data == $data_total_soal) {
            return "telah dikerjakan";
        } else if ($data > 0 && $data != $data_total_soal) {
            return "lanjutkan";
        }
        // else if ($data == $fixed_data) {
        //     return "selesai";
        // } else if ($data > 0) {
        //     return "lanjutkan";
        // }
    }

    // private function pack_all_data($kelasdata) {
    //     $pack = [];
    //     for($i = 0; $i < count($kelasdata); $i++) {
    //         if (time() > $kelasdata[$i]["unix"]) {
    //             $actual_kelas = $this->daftar_mapel_repo->get_mapel_info($kelasdata[$i]["kode_mapel"]);

    //             $additional2sent = [
    //                 "nama_mapel" => $actual_kelas["nama_mata_pelajaran"],
    //                 "status_dikerjakan" => count($this->on_runtime_pg_repo
    //                 ->get_all_unconfirmed_answer_by_siswa(
    //                     $this->cookie_identity, $kelasdata[$i]["kode_mapel"]
    //                 )) == 0 ? "belum dikerjakan" : "lanjutkan"
    //             ];
    //             $mergedarr = array_merge($additional2sent, $kelasdata[$i]->toArray());
    //             array_push($pack, $mergedarr);
    //         }
    //     }
    //     return $pack;
    // }

    private function generate_packed_data() {
        // $mapel_struct = [
        //     "nama_mapel" => null,
        //     "kode_mapel" => null, //  for kerjakan link
        //     "status_dikerjakan" => null,
        //     "exam_start" => null,
        //     "exam_end"  => null
        // ];
        $mapel_struct = new \StdClass();

        $pack = [];

        $true_exam = $this->get_matched_penugasan_by_kelas($this->get_current_class());
        for($i = 0; $i < count($true_exam); $i++) {
            if ($this->daftar_mapel_repo->mapel_exist($true_exam[$i]["kode_mapel"])) {
                if (time() > $true_exam[$i]["unix"]) {
                    $mapel_struct->nama_mapel = $this->get_real_mapel_name($true_exam[$i]["kode_mapel"]);
                    $mapel_struct->kode_mapel = $true_exam[$i]["kode_mapel"];
                    $mapel_struct->status_dikerjakan = $this->status_dikerjakan($true_exam[$i]["kode_mapel"]);
                    [$mapel_struct->start, $mapel_struct->end] = $this->get_start_end($true_exam[$i]["unix"], $true_exam[$i]["duration_time"]);
                    $mapel_struct->kerjakan_link = $true_exam[$i]["kode_mapel"];
                    array_push($pack, (array)$mapel_struct);
                }
            }
        }

        // dd($pack);

        return $pack;
    }

    private function get_start_end($timestamp, $duration) {
        $time = new \DateTimeImmutable();
        $start = $time->setTimestamp($timestamp)
            ->setTimezone(new \DateTimeZone("Asia/Jakarta"))
            ->format("H:i:s");

        $end = $time->setTimestamp($timestamp)
            ->setTimezone(new \DateTimeZone("Asia/Jakarta"))
            ->add(new \DateInterval("PT" . $duration . "M"))
            ->format("H:i:s");

        return [
            $start, $end
        ];

        // dd($end);
        // $end = $mewdata->format("H:i:s");


    }

    public function index(Request $request) {
        $this->request = $request;
        // dd();
        $this->cookie_deserialize();

        return view("views/dashboard", [
            "mapels_data" => $this->generate_packed_data()
        ]);
    }
}
