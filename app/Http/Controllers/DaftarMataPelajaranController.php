<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DaftarMataPelajaranController extends Controller
{
    //
    public function __construct(
        protected Repositories\DaftarMataPelajaranRepository $daftar_mapel_repo,
        protected Repositories\PengajarRepository $pengajar_repo
    ){}

    public function Create(Request $request) {
        // dd($request->get("mata_pelajaran"));
        $this->daftar_mapel_repo->generate_mata_pelajaran($request->get("mata_pelajaran"));
    }

    protected function pengampu_list2name($data) {
        $packed = [];
        foreach($data as $data_s) {
            $packed[] = $this->pengajar_repo->GetByID($data_s)["username"];
        }
        
        return $packed;
        // dd($packed);
    }

    public function Index() {
        $query = $this->daftar_mapel_repo->getAllAvailableMataPelajaran();
        // dd($query);
        // $query["pengampu"] = "saya";
        // dd($query["pengampu"]);
        for($i = 0; $i < count($query); $i++) {
            $query[$i]["pengampu"] = $this->pengampu_list2name(json_decode($query[$i]["pengampu"]));
        }

        // dd($query);

        return DataTables::of($query)
            ->rawColumns(["pengampu"])
            ->make();
    }

    public function Delete(Request $request) {
        $this->daftar_mapel_repo->deleteHardMataPelajaran($request->get("kode_mata_pelajaran"));
    }
    // operasi tambah soal, settings, dll dilakukan di soal controller

    public function set_mapel_config($kode_mapel, Request $request) {
        // dd(json_encode($request->pengampu));
        // dd($request->pengampu);
        $this->daftar_mapel_repo->set_mapel_config(
            $kode_mapel,
            $request->enable_right_click == "true" ? 1 : 0,
            $request->allow_copy == "true" ? 1 : 0,
            $request->pengampu != null ? json_encode($request->pengampu) : json_encode([])
        );
    }

    public function get_mapel_info($kode_mapel, Request $request) {
        return response()->json($this->daftar_mapel_repo->get_mapel_info($kode_mapel));
    }
}
