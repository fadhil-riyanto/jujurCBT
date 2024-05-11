<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminSiswaDelete extends Controller
{
    protected Request $request;

    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_db
    ) {}

    public function Delete(Request $request) {
        $this->request = $request;

        $request->validate([
            'nomor_ujian' => 'required'
        ]);

        $this->siswa_account_db->deleteSiswa($this->request->get("nomor_ujian"));
    }
}
