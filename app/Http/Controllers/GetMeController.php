<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Models;
use App\Enum;

class GetMeController extends Controller
{
    protected Request $request;

    use Traits\CurrentSessionTrait;
    private function returnNameAsRole():string {
        $cb = match($this->cookie_role) {
            Enum\RoleSessionEnum::Student => Models\SiswaAccountModel::where("nomor_ujian", $this->cookie_identity)->first(),
            Enum\RoleSessionEnum::Admin => Models\AdminAccountModel::where("username", $this->cookie_identity)->first()
        };

        return $cb->nama;
        
    }
    public function getData(Request $request)
    {
        $this->request = $request;
        $this->cookie_deserialize();
        
        return response([
            "data" => $this->returnNameAsRole()
        ]);
    }
}
