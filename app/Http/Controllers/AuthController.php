<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SiswaAccountModel;
use App\Models\AdminAccountModel;
use App\Models\SuperadminModel;

use Illuminate\Support\Facades\Cookie;

use App\Enum as Enumlist;
use App\Exceptions\RoleNullException;

class credential_return {
    public function __construct(public string $user, public string $password) {}
}

class checkAuth {
    private Request $request;
    private string $message = "none";
    private string $login_as = "none";
    private bool $status = false;

    // terima data dari req
    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    // req ke database

    private function getDataFromModelsAsStudent($nomor_ujian): credential_return|null {
        $ret = SiswaAccountModel::where('nomor_ujian', $nomor_ujian)->first();
        return ($ret != null) ? new credential_return(
            $ret->nomor_ujian,
            $ret->password
        ) : null;
    }

    private function getDataFromModelsAsAdmin($username): credential_return|null {
        $ret = AdminAccountModel::where('username', $username)->first();
        return ($ret != null) ? new credential_return(
            $ret->username,
            $ret->password
        ) : null;
    }

    private function getDataFromModelsAsSuperAdmin($username): credential_return|null {
        $first_search_db = SuperadminModel::all();
        // dd($first_search_db[0]);
        if (count($first_search_db) != 0) {
            if ($first_search_db[0]->username == $username && strtolower($first_search_db[0]->username) != "admin") {
                // first scenario, user already change default password, but not as 'admin'
                return new credential_return(
                    $first_search_db[0]->username,
                    $first_search_db[0]->password
                );
            }
        } else { // username and password is not set yet
            if ($username == env("SUPERADMIN_DEFAULT_USER", null)) {
                return new credential_return(
                    env("SUPERADMIN_DEFAULT_USER", null),
                    env("SUPERADMIN_DEFAULT_PASS", null)
                );
            }
        }
        return null;

        
    }

    

    private function getDataByRole()
    {
        if ($this->request->has("role")) {
            if ($this->request->get("role") == "student") {
                $this->login_as = "student";
                return $this->getDataFromModelsAsStudent($this->request->get("identity"));
            }else if ($this->request->get("role") == "superadmin") {
                $this->login_as = "superadmin";
                return $this->getDataFromModelsAsSuperAdmin($this->request->get("identity"));
            } else if ($this->request->get("role") == "pengajar") {
                $this->login_as = "pengajar";
                return $this->getDataFromModelsAsAdmin($this->request->get("identity"));
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
                $this->Compare($this->request->get("password"), $result->password);
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

    public function putCookieData(): array { // used as cookie
        return [
            "status" => $this->status,
            "role" => $this->login_as,
            "identity" => $this->request->get("identity")
        ];
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
            "message" => $this->message,
            "redirect" => match ($this->login_as) {
                "superadmin" => "/admin/welcome",
                "student" => "/dashboard",
                "pengajar" => "/pengajar",
                default => null 
            }
        ];
    }
}

class AuthController extends Controller
{

    private $message, $login_as;
    private checkAuth $auth;
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
            $this->auth = new checkAuth($request);
            $this->message = $this->auth->GetResult()["message"];
            $this->redirect = $this->auth->GetResult()["redirect"];
            return $this->auth->GetResult()["status"];
        }
        return 0;
    }
    public function login(Request $request)
    {    
        // $this->GetLoginStatus($request);
        // dd($this->auth->putCookieData());
        return response([
            "status" => $this->GetLoginStatus($request),
            "message" => $this->message,
            "redirect" => $this->redirect
        ])

        ->cookie(cookie('login_data', serialize(
            $this->auth->putCookieData()
        ), 200));
        
    }
}
