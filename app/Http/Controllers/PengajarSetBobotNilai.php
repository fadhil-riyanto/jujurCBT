<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class PengajarSetBobotNilai extends Controller
{
    public function __construct(
        private Repositories\PenugasanRepository $penugasan_repo
    ) {}

    public function Index(Request $request) {
        $request->validate([
            "bobot_essay" => "required",
            "penugasan_id" => "required"
        ]);

        $this->penugasan_repo->set_bobot_nilai_essay($request->penugasan_id, $request->bobot_essay);
    }
}
