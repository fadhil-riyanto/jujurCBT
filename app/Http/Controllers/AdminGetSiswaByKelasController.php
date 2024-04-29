<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminGetSiswaByKelasController extends Controller
{
    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_db, 
        protected Repositories\AdminAccountRepository $admin_account_db
    ) {}

    protected Request $request;
    protected mixed $userdata;

    private function getAllData() {
        $this->userdata = $this->siswa_account_db->getByTable("kelas",$this->request->get("kelas"))->get();
    }

    private function serialize_data(): array {
        // dd($this->userdata);
        $stack = array();

        foreach($this->userdata as $userdatas) {
            array_push($stack, [
                "id" => $userdatas->id,
                "nama" => $userdatas->nama,
                "kelas" => $userdatas->kelas,
                "nomor_ujian" => $userdatas->nomor_ujian,
                "password" => $userdatas->password,
                "blokir" => $userdatas->blokir
            ]);
        }
        
        return [
            "data" => $stack
        ];
    }

    public function getData(Request $request) {
        $this->request = $request;

        $this->getAllData();
        $this->serialize_data();

        return response($this->serialize_data());
    }
}
