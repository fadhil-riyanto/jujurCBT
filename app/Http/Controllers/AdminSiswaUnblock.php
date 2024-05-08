<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminSiswaUnblock extends Controller
{
    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_repo
    ) {}

    public function doUnblock(Request $request) {
        if ($request->has("nomor_ujian")) {
            $this->siswa_account_repo->unblockSiswa($request->get("nomor_ujian"));
            return response("ok");
        } else {
            return response("invalid");
        }
        
    }
}
