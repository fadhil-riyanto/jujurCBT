<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Traits;

class GetMataPelajaranController
{
    use Traits\CurrentSessionTrait;

    protected $request;
    protected $dumped_data;
    protected $mata_pelajaran_filtered = [];

    private function dumpAllDataFromDatabase()
    {
        $this->dumped_data = Models\SoalModel::all();
    }

    private function literate()
    {
        foreach($this->dumped_data as $dumped_data_l) {
            if (in_array($dumped_data_l->mata_pelajaran, $this->mata_pelajaran_filtered)) {
                // skip
            } else {
                array_push($this->mata_pelajaran_filtered, $dumped_data_l->mata_pelajaran);
            }
        }
    }

    private function getMataPelajaranByAssigment()
    {
        $dbs = Models\DaftarAssigmentModel::where("nomor_ujian", $this->cookie_identity);
        dd($dbs);
    }

    private function execute()
    {
        // GET DATA FROM COOKIE, use session cookie
        $this->cookie_deserialize();
        $this->dumpAllDataFromDatabase();
        $this->literate();
        $this->getMataPelajaranByAssigment();
    }

    public function GetData(Request $request): array
    {
        $this->request = $request;
        return $this->execute();
    }
}
