<?php

namespace App\Repositories;
use App\Repositories\Interfaces;
use App\Models;

class SiswaAccountRepository implements Interfaces\IAccount {
    protected $modelname;
    protected $ctx;

    public function __construct() 
    {
        $this->modelname = new Models\SiswaAccountModel;
    }

    public function getByID(int $id) {
        $this->ctx = $this->modelname::where("id", $id);
        return $this;
    }

    public function getByTable(string $column, mixed $value) {
        $this->ctx = $this->modelname::where($column, $value);
        return $this;
    }

    public function getAll() {
        $this->ctx = $this->modelname::all();
        return $this;
    }

    public function getFirst() {
        if ($this->ctx->first() == null) {
            throw new Exceptions\DataNotFoundByModel();
        } else {
            return $this->ctx->first();
        }
    }

    public function get() {
        return $this->ctx->get();
    }

    public function store($nama, $kelas, $nomor_ujian, $password) {
        $this->modelname->nama = $nama;
        $this->modelname->kelas = $kelas;
        $this->modelname->nomor_ujian = $nomor_ujian;
        $this->modelname->password = password_hash($password, PASSWORD_ARGON2ID);
        $this->modelname->blokir = true; // default, jika siswa dah bayar spp, maka dibuka dari sistem na
        $this->modelname->save();
    }

    public function getAllByColumn($columns) {
        
        // dd($this->modelname::all($columns));
        // $this->ctx = $this->modelname::all($columns);
        return $this->modelname::all($columns);
    }

    public function getAllDistinctByColumn($columns) {
        
        // dd($this->modelname::all($columns));
        // $this->ctx = $this->modelname::all($columns);
        return $this->modelname::all($columns);
    }

    // custom function here
    public function RetrieveAllOfTheAvailableClass() {
        return $this->modelname->select("kelas")->distinct()->get();
    }

    public function isNomorUjianDuplication($search): bool {
        if(count($this->modelname->select("nomor_ujian")->where("nomor_ujian", $search)->get()) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function unblockSiswa($nomor_ujian) {
        $this->modelname::where('nomor_ujian', $nomor_ujian)
            ->update(["blokir" => 0]);
    }

    public function blockSiswa($nomor_ujian) {
        $this->modelname::where('nomor_ujian', $nomor_ujian)
            ->update(["blokir" => 1]);
    }

    public function showBlockStatus($nomor_ujian) {
        return $this->modelname->select("blokir")
            ->where('nomor_ujian', $nomor_ujian)
            ->first()
            ->blokir;
    }


    public function siswaDetails($nomor_ujian) {
        return $this->modelname
            ->where('nomor_ujian', $nomor_ujian)
            ->first();
    }

    public function changePassword($nomor_ujian, $new_hashed_password) {
        return $this->modelname::where('nomor_ujian', $nomor_ujian)
            ->update(["password" => $new_hashed_password]);
    }

    public function changeNama($nomor_ujian, $new_hashed_password) {
        return $this->modelname::where('nomor_ujian', $nomor_ujian)
            ->update(["nama" => $new_hashed_password]);
    }

    public function deleteSiswa($nomor_ujian) {
        return $this->modelname::where('nomor_ujian', $nomor_ujian)
            ->delete();
    }
}