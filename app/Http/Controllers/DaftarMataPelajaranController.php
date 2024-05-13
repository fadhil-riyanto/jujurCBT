<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DaftarMataPelajaranController extends Controller
{
    //
    public function __construct(
        protected Repositories\DaftarMataPelajaranRepository $daftar_mapel_repo
    ){}

    public function Create(Request $request) {
        // dd($request->get("mata_pelajaran"));
        $this->daftar_mapel_repo->generate_mata_pelajaran($request->get("mata_pelajaran"));
    }

    public function Index() {
        return DataTables::of($this->daftar_mapel_repo->getAllAvailableMataPelajaran())->make();
    }

    public function Delete(Request $request) {
        $this->daftar_mapel_repo->deleteHardMataPelajaran($request->get("kode_mata_pelajaran"));
    }
}
