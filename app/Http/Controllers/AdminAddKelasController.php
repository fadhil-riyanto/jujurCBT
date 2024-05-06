<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;
use App\Exceptions;

class AdminAddKelasController extends Controller
{
    private Request $request;

    public function __construct (
        protected Repositories\KelasRepository $kelas_repo
    ) {}

    private function validate() {
        if ($this->request->has("kelas")) {
            try {
                $this->kelas_repo->add_kelas(
                    normal2snake_case($this->request->get("kelas")
                ));

                return [
                    "message" => true
                ];
            } catch (Exceptions\ClassAlreadyAdded) {
                return [
                    "message" => "kelas sudah ada"
                ];
            }
            
            return "ok";
        } else {
            return "invalid";
        }
    }

    public function Add(Request $request) {
        $this->request = $request;
        return response($this->validate());
    }
    
}
