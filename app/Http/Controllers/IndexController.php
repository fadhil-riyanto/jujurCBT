<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Enum;

class IndexController extends Controller
{
    use Traits\CurrentSessionTrait;

    protected Request $request;

    public function IndexController(Request $request)
    {
        $this->request = $request;
        $request->session()->put('key', 'valuefromfirstuser');

        $this->cookie_deserialize();
        return redirect(match($this->cookie_role) {
            Enum\RoleSessionEnum::SuperAdmin => "/admin/welcome",
            Enum\RoleSessionEnum::Student => "/dashboard",
            Enum\RoleSessionEnum::Pengajar => "/pengajar"
        });
    }
}
