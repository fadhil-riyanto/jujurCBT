<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminSiswaChangePassword extends Controller
{
    protected Request $request;

    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_db
    ) {}

    public function Change(Request $request) {
        $this->request = $request;

        $request->validate([
            'password' => 'required',
            'nomor_ujian' => 'required'
        ]);

        $this->siswa_account_db->changePassword(
            $this->request->get("nomor_ujian"),
            password_hash(
                $this->request->get("password"), PASSWORD_ARGON2I
            )
        );
    }
}
