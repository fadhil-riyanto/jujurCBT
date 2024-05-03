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
            // "kelas" => ["required"],
            // "nomor_ujian" => ["required"],
            "password" => ["required"]
        ]);

        return $validator;
    }
    
    private function gen_random_ids() {
        $microtime = explode(".", explode(" ", microtime())[0])[1];
        $unix = time();
        return substr($microtime * $unix, 0, 7);
    }

    private function genRandomNomorUjian() {
        do {
            $randomids = $this->gen_random_ids();
            $result = $this->siswa_account_db->isNomorUjianDuplication($this->gen_random_ids());
        } while ($result == true);

        return $randomids;
    }

    private function IsvalidateFail() {
        // $this->genRandomNomorUjian();
        if ($this->validate()->fails()) {
            return ["status" => "false"];
        } else {
            $this->siswa_account_db->store(
                $this->request->get("nama"), 
                "12_tkj_1", 
                $this->genRandomNomorUjian(),
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
