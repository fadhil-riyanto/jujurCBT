<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Enum;
use App\Repositories;
use App\Exceptions;

class GetMeController extends Controller
{
    protected Request $request;
    use Traits\CurrentSessionTrait;
    
    public function __construct(
        protected Repositories\SiswaAccountRepository $siswa_account_db, 
        protected Repositories\AdminAccountRepository $admin_account_db, 
    ) {}

    private function returnNameAsRole(): string {
        try {
            $cb = match($this->cookie_role) {
                Enum\RoleSessionEnum::Student => 
                    $this->siswa_account_db->getByTable("nomor_ujian", $this->cookie_identity),
                Enum\RoleSessionEnum::Admin => 
                    $this->admin_account_db->getByTable("username", $this->cookie_identity)
            };
            return $cb->getFirst()->nama;
        } catch (Exceptions\DataNotFoundByModel) {
            return "error";
        }
        
        
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
