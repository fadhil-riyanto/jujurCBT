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
        protected Repositories\SuperAdminCredentialRepository $superadmin_credential_db,  // warning, deprecated
        protected Repositories\PengajarRepository $pengajar_credential_db,  // warning, deprecated
        
    ) {}

    private function returnNameAsRole(): string {
        try {
            if ($this->cookie_role == Enum\RoleSessionEnum::Student) {
                // dd($this->siswa_account_db->getByTable("nomor_ujian", $this->cookie_identity));
                return $this->siswa_account_db->getByTable("nomor_ujian", $this->cookie_identity)
                    ->getFirst()->nama;
            } else if ($this->cookie_role == Enum\RoleSessionEnum::SuperAdmin) {
                return $this->superadmin_credential_db->getByTable("username", $this->cookie_identity)
                    ->getFirst()->username;
            } else if ($this->cookie_role == Enum\RoleSessionEnum::Pengajar) {
                return $this->pengajar_credential_db->get_pengajar_info_by_identity($this->cookie_identity)
                    ->username;
            }
            // $cb = match($this->cookie_role) {
            //     Enum\RoleSessionEnum::Student => 
            //         $this->siswa_account_db->getByTable("nomor_ujian", $this->cookie_identity),
            //     Enum\RoleSessionEnum::SuperAdmin => 
            //         $this->superadmin_credential_db->getByTable("username", $this->cookie_identity)
            // };
            // return $cb->getFirst()->username;
        } catch (Exceptions\DataNotFoundByModel) {
            if ($this->cookie_role == Enum\RoleSessionEnum::SuperAdmin) {
                return "Admin";
            }
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
