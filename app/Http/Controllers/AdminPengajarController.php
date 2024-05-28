<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminPengajarController extends Controller
{
    public function __construct(
        protected Repositories\PengajarRepository $pengajar_repo
    ){}

    protected function build_datatables_format($dataarr) {

    }

    public function index(Request $request)
    {
        $pack = [];

        foreach($this->pengajar_repo->getAll() as $data) {
            $data2sent = "data-id=\"" . $data["id"] . "\"";

            $btn1 = "<button type=\"button\" class=\"btn btn-primary btnedit me-3\" " . $data2sent .  ">ubah</button>";
            $btn2 = "<button type=\"button\" class=\"btn btn-danger btndelete\" " . $data2sent .  ">hapus</button>";
            
            $data["aksi"] = $btn1 . $btn2;
            $pack[] = $data;
        }
        // if ($request->ajax()) // determine src from js-eval xhr
            return DataTables::of($pack)->rawColumns(["aksi"])->make();
            // return response()->json($pack);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "create method ok";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->pengajar_repo->storeNewPengajar(
            $request->get("nama"),
            $request->get("username"),
            $request->get("password")
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        
        return "datatables obj";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->pengajar_repo->GetByID($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->pengajar_repo->updateById($id, 
            $request->get("nama"),
            $request->get("username"),
            $request->get("password")
        );
        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->pengajar_repo->delete($id);
    }
}
