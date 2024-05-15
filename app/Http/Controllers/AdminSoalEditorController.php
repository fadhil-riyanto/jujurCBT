<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminSoalEditorController extends Controller
{
    //
    public function __construct(
        protected Repositories\AdminSoalEditorRepository $admin_soal_editor_repo
    ){}

    public function create_new_soal($kode_mapel) {
        
        return response()->json(
            [
                "new_id" => $this->admin_soal_editor_repo->setkodeSoal($kode_mapel)->create_new_soal(),
                "total_soal_len" => $this->admin_soal_editor_repo->setkodeSoal($kode_mapel)
                    ->getTotalSoalByKodeMapel()

            ]
        );
    }

    public function get_total_soal_with_ids($kode_mapel) {
        $query = $this->admin_soal_editor_repo->setkodeSoal($kode_mapel)
            ->getAllSoalByKodeMapel();
        return response()->json($query);
    }

    public function get_soal_details($kode_mapel, $id_soal) {
        $query = $this->admin_soal_editor_repo->setkodeSoal($kode_mapel)->getSoalDetails($id_soal);
        return response()->json($query);
    }

    public function store_soal_jawaban($kode_mapel, $id_soal, Request $request) {
        $data = match ($request->get("soal_type")) {
            "pilihan_ganda" => function($kode_mapel, $id_soal, $request) {
                $this->admin_soal_editor_repo->setkodeSoal($kode_mapel)
                    ->store_pilihan_ganda($id_soal,
                        $request->get("soal"), 
                        literal2charindex($request->get("kunci_jawaban"))
                    );
            },
            "essay" => function($kode_mapel, $id_soal, $request) {
                return "handle essay";
            },
            default => null,
        };
        return $data($kode_mapel, $id_soal, $request);
    }
}
