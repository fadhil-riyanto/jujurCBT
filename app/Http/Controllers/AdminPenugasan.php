<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;
use Yajra\DataTables\Facades\DataTables;

class AdminPenugasan extends Controller
{
    //
    public function __construct(
        protected Repositories\PenugasanRepository $penugasan_repo,
        protected Repositories\DaftarMataPelajaranRepository $daftar_mapel_repo
    ){}

    public function store(Request $request) {
        $this->penugasan_repo->insertPenugasan($request);
    }

    public function getAll(Request $request) {
        $pack = [];
        foreach($this->penugasan_repo->getAll() as $data) {
            if($this->daftar_mapel_repo->mapel_exist($data["kode_mapel"])) {
                $actual_classname = $this->daftar_mapel_repo->get_mapel_info($data["kode_mapel"])["nama_mata_pelajaran"];

                $dump = [
                    "nama_mata_pelajaran" => $actual_classname
                ];
                // dd();
                array_push($pack, array_merge($data->toArray(), $dump));
            } else {
                // $dump = [
                //     "nama_mata_pelajaran" => "(Mata pelajaran tidak ditemukan)"
                // ];
                // // dd();
                // array_push($pack, array_merge($data->toArray(), $dump));
                $this->delete($data["id"]);
            }
            
        }
        return DataTables::of($pack)->make();
    }

    public function delete($id) {
        $this->penugasan_repo->remove($id);
    }
}
