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
        $this->penugasan_repo->insertPenugasanOrCreate($request);
    }

    public function getAll(Request $request) {
        $pack = [];
        foreach($this->penugasan_repo->getAll() as $data) {
            $actual_classname = $this->daftar_mapel_repo->get_mapel_info($data["kode_mapel"])["nama_mata_pelajaran"];
            // merge two array

            $dump = [
                "nama_mata_pelajaran" => $actual_classname
            ];
            // dd();
            array_push($pack, array_merge($data->toArray(), $dump));
        }
        return DataTables::of($pack)->make();
    }

    public function delete($id) {
        $this->penugasan_repo->remove($id);
    }
}
