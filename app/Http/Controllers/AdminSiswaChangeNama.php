<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminSiswaChangeNama extends Controller
{
    protected Request $request;

    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_db
    ) {}

    // private function whichIs(): ChangeMode|null{
    //     if ($request->has("nama")) {
    //         return ChangeMode::ChangeNama;
    //     } else if ($request->has("password")) {
    //         return ChangeMode::ChangePassword;
    //     } else {
    //         return null;
    //     }
    // }

    public function Change(Request $request) {
        $this->request = $request;

        $request->validate([
            'nama' => 'required',
            'nomor_ujian' => 'required'
        ]);

        $this->siswa_account_db->changeNama(
            $this->request->get("nomor_ujian"),
            $this->request->get("nama")
        );
    }
}
