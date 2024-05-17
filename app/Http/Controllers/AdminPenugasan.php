<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories;
use Yajra\DataTables\Facades\DataTables;

class AdminPenugasan extends Controller
{
    //
    public function __construct(
        protected Repositories\PenugasanRepository $penugasan_repo
    ){}

    public function store(Request $request) {
        $this->penugasan_repo->insertPenugasanOrCreate($request);
    }

    public function getAll(Request $request) {
        return DataTables::of($this->penugasan_repo->getAll())->make();
    }

    public function delete($id) {
        $this->penugasan_repo->remove($id);
    }
}
