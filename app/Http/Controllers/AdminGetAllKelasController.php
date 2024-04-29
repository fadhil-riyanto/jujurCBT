<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;

class AdminGetAllKelasController extends Controller
{
    public function __construct(
        private Repositories\SiswaAccountRepository $siswa_account_db
    ){}

    public function getData(Request $request) {
        return response($this->siswa_account_db->RetrieveAllOfTheAvailableClass("kelas"));
    }
}
