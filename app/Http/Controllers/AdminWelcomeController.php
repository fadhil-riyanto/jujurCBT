<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use Illuminate\Support\Facades\DB;

class AdminWelcomeController extends Controller
{
    // just littebit gathering informatio, no repository use
    //
    public function __construct(
        protected Models\SiswaAccountModel $siswa_db
    ) {}

    protected function get_siswa_total_blocked(): int {
        // return 
        return $this->siswa_db->where("blokir", "=", 1)
            ->select(DB::raw("COUNT(*) as total"))
            ->first()["total"];
    }

    protected function get_siswa_total_unblocked(): int {
        // return 
        return $this->siswa_db->where("blokir", "=", 0)
            ->select(DB::raw("COUNT(*) as total"))
            ->first()["total"];
    }

    protected function get_siswa_total(): int {
        // return 
        return $this->siswa_db
            ->select(DB::raw("COUNT(*) as total"))
            ->first()["total"];
    }

    /**
     * [
            "jumlah" => "",
            "siswa_terblokir" => "",
            "siswa_aktif" => ""
        ]
     */
    public function index() {
        return view("views/admin_welcome", [
            "siswa_blocked" => $this->get_siswa_total_blocked(),
            "siswa_unblocked" => $this->get_siswa_total_unblocked(),
            "total" => $this->get_siswa_total()
        ]);
    }
}
