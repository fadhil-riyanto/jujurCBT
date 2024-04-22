<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SiswaAccountModel;
use App\Models\AdminAccountModel;

use Illuminate\Support\Facades\Cookie;

use App\Enum as Enumlist;
use App\Exceptions\RoleNullException;


class checkAuth {
    private Request $req;
    private string $message = "none";
    private bool $status = false;

    // terima data dari req
    public function __construct(Request $req) {
        $this->req = $req;
    }

    // req ke database

    private function getDataFromModelsAsStudent($nomor_ujian): SiswaAccountModel|null {
        return SiswaAccountModel::where('nomor_ujian', $nomor_ujian)->first();
    }

    private function getDataFromModelsAsAdmin($username): AdminAccountModel|null {
        return AdminAccountModel::where('username', $username)->first();
    }

    private function getDataByRole()
    {
        if ($this->req->has("role")) {
            if ($this->req->get("role") == "student") {
                return $this->getDataFromModelsAsStudent($this->req->get("identity"));
            } else if ($this->req->get("role") == "admin") {
                return $this->getDataFromModelsAsAdmin($this->req->get("identity"));
            } else {
                $this->message = "role tidak ditemukan!";
                throw new RoleNotFoundException();
            }
        } else {
            $this->message = "Mohon pilih sebagai apa anda login!";
            throw new RoleNullException();
        }
    }

    // cek password dari database

    public function getPasswordFromObj()
    {
        try{
            $result = $this->getDataByRole();
            if ($result != null) {
                $this->Compare($this->req->get("password"), $result->password);
            } else {
                $this->message = "identitas tidak ditemukan";
            }


        } catch (RoleNullException | RoleNotFoundException) {
            $this->status = false;
        }
        
        // if ($result == null)
        // {
        //     $this->message = "nomor ujian tidak ditemukan";
        //     return 0;
        // } else {
        //     return $result->password;
        // }
        
    }

    private function Compare($password_from_user, $password_from_db): void
    {
        $res = password_verify($password_from_user, $password_from_db);
        if ($res == false) {
            $this->message = "password salah";
         
        } else {
            $this->message = "login berhasil";
            $this->status = true;
        }
    }

    public function GetResult()
    {
        $this->getPasswordFromObj();

        // return
        // status = true or false, true for correct password
        // messange = custom messange for server
        // login
        return [
            "status" => $this->status,
            "message" => $this->message
        ];
    }
}

class LoginController extends Controller
{

    private $message;
    public function validateRequest($request): bool
    {
        if($request->has('identity') && $request->has('password'))
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
        // $cookie = 
        // Cookie::queue(cookie('login_status', "oke", 600));

        // send cookie to user
        return response([
            "status" => $this->GetLoginStatus($request),
            "message" => $this->message

        ])->cookie(cookie('login_status', $this->GetLoginStatus($request), 600))
            ->cookie(cookie('debugtwo', true, 600));
        
    }
}
