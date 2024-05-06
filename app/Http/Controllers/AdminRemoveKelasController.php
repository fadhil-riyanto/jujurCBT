<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminRemoveKelasController extends Controller
{
    public function __construct(
        protected Repositories\KelasRepository $KelasRepository
    ) {}

    private function validate() {
        if ($this->request->has("kelas")) {
            try {
                
                dd($this->KelasRepository->remove_kelas($this->request->get("kelas")));
                return [
                    "messange" => true
                ];
            } catch (Exceptions\ClassAlreadyAdded) {
                return [
                    "messange" => "kelas sudah ada"
                ];
            }
            
            return "ok";
        } else {
            return "invalid";
        }
    }

    public function Remove(Request $request) {
        $this->request = $request;
        return $this->validate();
    }
}
