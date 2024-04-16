<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SiswaAccountModel;

use App\Enum as Enumlist;
use App\Exception;


class checkAuth {
    private Request $req;
    private string $message = "none";

    // terima data dari req
    public function __construct(Request $req) {
        $this->req = $req;
    }

    // req ke database

    private function getDataFromModels($nomor_ujian) :SiswaAccountModel|null {
        return SiswaAccountModel::where('nomor_ujian', $nomor_ujian)->first();
    }

    // cek password dari database

    public function getPasswordFromObj($nomor_ujian)
    {
        $result = $this->getDataFromModels($nomor_ujian);
        if ($result == null)
        {
            $this->message = "nomor ujian tidak ditemukan";
            return 0;
        } else {
            return $result->password;
        }
        
    }



    private function Compare(): bool
    {
        $res = password_verify($this->req->get("password"), $this->getPasswordFromObj($this->req->get("nomor_ujian")));
        if ($res == false) {
            $this->message = "password salah";
        } else {
            $this->message = "login berhasil";
        }
        return $res;
    }

    public function GetResult()
    {
        return [
            "status" => $this->Compare(),
            "message" => $this->message
        ];
    }
}

class LoginController extends Controller
{

    private $message;
    public function validateRequest($request): bool
    {
        if($request->has('nomor_ujian') && $request->has('password'))
        {
            $this->message = "valid_request";
            return 1;
        } else {
            $this->message = "invalid_request";
            return 0;
        }
    }
    public function getLoginStatus($request): bool
    {
        // apakah req valid>
        if($this->validateRequest($request))
        {
            // valdated, with message filled
            $auth = new checkAuth($request);
            $this->message = $auth->GetResult()["message"];
            return $auth->GetResult()["status"];
        }
        return 0;
    }
    public function login(Request $request)
    {
        // set cookie to user
        $cookie = cookie('status', $this->GetLoginStatus($request), 600);

        // send cookie to user
        return response([
            "message" => $this->message
        ])->cookie($cookie);
        
    }
}
