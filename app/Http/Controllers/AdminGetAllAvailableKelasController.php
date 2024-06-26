<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminGetAllAvailableKelasController extends Controller
{
    public function __construct(
        private Repositories\KelasRepository $KelasRepository
    ){}

    private function class_db_unpack($string): string {
        return strtoupper(str_replace("_", " ", $string));
    }

    private function retrieve_data() {
        return $this->KelasRepository->RetrieveAllOfTheAvailableClass();
    }

    private function serialize() {
        $arr = [];
        foreach($this->retrieve_data() as $data) {
            $arr[] = [
                "data" => $data->kelas,
                "view" => normal2snake_case_invers($data->kelas)
            ];
        }
        return $arr;
        // dd($arr);
    }

    public function getData(Request $request) {
        // $this->KelasRepository->
        // return response(dd());
        // dd($this->retrieve_data());
        return response($this->serialize());
    }
}
