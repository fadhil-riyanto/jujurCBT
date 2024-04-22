<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoalModel;

class GetMataPelajaranController extends Controller
{
    protected $req;
    protected $dumped_data;
    protected $mata_pelajaran_filtered = [];
    public function __construct(Request $req, $nomor_ujian) {
        $this->req = $req;
        $this->execute();
    }

    private function dumpData()
    {
        $this->dumped_data = SoalModel::all();
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

    private function execute()
    {
        $this->dumpData();
        $this->literate();
    }

    public function GetResult(): array {
        return $this->mata_pelajaran_filtered;
    }
}
