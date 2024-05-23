<?php

namespace App\Repositories;
use App\Repositories\Interfaces;
use App\Models;

class SuperadminRepository {
    public function __construct() {
        $this->model = new Models\SuperadminModel;
    }

    /* 
     * repo ini hanya ada get() untk verifikasi kredensial
     * set() untuk ngatur password
     * setusername untuk ngatur username
     * 
     * semua operasi hanya untuk 1 kolom
    */

    public function get() {
        return $this->model::all()->first();
    }
}