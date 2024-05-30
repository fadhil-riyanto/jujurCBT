<?php

namespace App\Repositories;
use App\Models;

class PengajarRepository {
    public function __construct(
        protected Models\PengajarModel $modelname
    ){}

    public function getAll() {
        return $this->modelname::all();
    }

    public function GetByID($id) {
        return $this->modelname::find($id);
    }

    public function storeNewPengajar($nama, $username, $password) {
        $this->modelname->nama = $nama;
        $this->modelname->username = $username;
        $this->modelname->password = password_hash($password, PASSWORD_ARGON2I);
        $this->modelname->save();
    }

    public function updateById($id, $nama, $username, $password) {
        $found = $this->modelname::find($id);
        $found->nama = $nama;
        $found->username = $username;
        $found->password = password_hash($password, PASSWORD_ARGON2I);
        $found->save();
    }

    public function delete($id) {
        $found = $this->modelname::find($id);
        $found->forceDelete();
    }

    public function get_pengajar_info_by_identity($username) {
        return $this->modelname->where("username", "=", $username)->first();
    }
} 