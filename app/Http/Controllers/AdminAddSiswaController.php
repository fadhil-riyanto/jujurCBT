<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;
use Illuminate\Support\Facades\Validator;



class AdminAddSiswaController extends Controller
{
    protected Request $request;

    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_db
    ) {}

    private function validate() {
        $validator = Validator::make($this->request->all(), [
            "nama" => ["required", "max:255"],
            "kelas" => ["required"],
            "nomor_ujian" => ["required"],
            "password" => ["required"]
        ]);

        return $validator;
    }

    private function IsvalidateFail() {
        if ($this->validate()->fails()) {
            return ["status" => "false"];
        } else {
            $this->siswa_account_db->store(
                $this->request->get("nama"), 
                $this->request->get("kelas"), 
                $this->request->get("nomor_ujian"), 
                $this->request->get("password")
            );
            return ["status" => "true"];
        }
    }

    public function Add(Request $request) {
        $this->request = $request;
        return response($this->IsvalidateFail());
    }
}
