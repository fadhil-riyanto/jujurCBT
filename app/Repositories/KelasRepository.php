<?php

namespace App\Repositories;
use App\Models;
use App\Exceptions;

class KelasRepository {
    public function __construct() {
        $this->model = new Models\KelasModel;
    }

    public function isFound(string $namakelas) {
        return $this->model::where("kelas", $namakelas)->first() == null ? false : true;
    }

    public function add_kelas(string $classname) {
        if ($this->isFound($classname)) {
            // send class is already added
            // throw exception
            throw new Exceptions\ClassAlreadyAdded();
        } else {
            $this->model->kelas = $classname;
            $this->model->save();
        }
        // $this->model->kelas = $classname;
        // $this->model->save();
    }

    public function RetrieveAllOfTheAvailableClass() {
        return $this->model->select("kelas")->get();
    }

    public function remove_kelas(string $classname) {
        return $this->model::where('kelas', $classname)->delete();
    }
}