<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminSiswaBlock extends Controller
{
    //
    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_repo
    ) {}

    public function doBlock(Request $request) {
        if ($request->has("nomor_ujian")) {
            // dd($this->siswa_account_repo->showBlockStatus($request->get("nomor_ujian")));
            $this->siswa_account_repo->blockSiswa($request->get("nomor_ujian"));
            return response("ok");
        } else {
            return response("invalid");
        }
    }
}
