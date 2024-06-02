<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Repositories;

class PengajarNilaiController extends Controller
{
    // make list of nilai
    use Traits\CurrentSessionTrait;

    public function __construct(
        protected Repositories\DaftarMataPelajaranRepository $daftar_mapel_repo,
        protected Repositories\PengajarRepository $pengajar_repo,
        protected Repositories\PenugasanRepository $penugasan_repo
    ) {}
    
    private function list_mapel_by_pengampu() : \iterator {
        $mapel_all = $this->daftar_mapel_repo->getAllAvailableMataPelajaran();
        $current_id = $this->pengajar_repo->get_pengajar_info_by_identity($this->cookie_identity)["id"];


        foreach($mapel_all as $mapel_all_i) {
            $pengampu_lists = json_decode($mapel_all_i["pengampu"]);
            foreach($pengampu_lists as $pengampu_lists_i) {
                if ($current_id == $pengampu_lists_i) {
                    yield $mapel_all_i;
                }
            }
        }
    }
    
    private function get_penugasan_by_kode_mapel_pengampu() : \iterator {
        foreach($this->list_mapel_by_pengampu() as $data_mapel) {
            // dd($this->penugasan_repo->get_penugasan_by_kode_mapel($data_mapel["kode_mata_pelajaran"])->toArray());
            // dd($data_mapel);
            // yield ->toArray();
            foreach($this->penugasan_repo->get_penugasan_by_kode_mapel($data_mapel["kode_mata_pelajaran"]) as $pengampu_mapel) {

                yield [
                    "id" => $pengampu_mapel["id"],
                    "kelas_id" => $pengampu_mapel["kelas_id"],
                    "kode_mapel" => $pengampu_mapel["kode_mapel"],
                    "start_date" => $pengampu_mapel["start_date"],
                    "start_time" => $pengampu_mapel["start_time"],
                    "duration_time" => $pengampu_mapel["duration_time"],
                    "unix" => $pengampu_mapel["unix"],

                    // additional
                    "nama_mapel" => $this->daftar_mapel_repo->get_mapel_info($pengampu_mapel["kode_mapel"])["nama_mata_pelajaran"],
                    
                ];
            }
        }

        // return $pack;
    }

    public function IndexNilai(Request $request) {
        $this->request = $request;
        $this->cookie_deserialize();

        $data2ret = iterator_to_array($this->get_penugasan_by_kode_mapel_pengampu());
        // dd($data2ret);
        return view('views/pengajar_nilai', [
            "data" => $data2ret
        ]);

    }

    public function IndexKoreksiEssay(Request $request) {
        $this->request = $request;
        $this->cookie_deserialize();

        $data2ret = iterator_to_array($this->get_penugasan_by_kode_mapel_pengampu());
        // dd($data2ret);
        return view('views/pengajar_koreksi_essay', [
            "data" => $data2ret
        ]);

    }
}
