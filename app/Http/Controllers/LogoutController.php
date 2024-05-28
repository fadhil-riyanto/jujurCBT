<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    //
    public function Index(Request $request) {
        if (Cookie::has("login_data")) {
            Cookie::expire("login_data");
            return redirect("/");
        }
        // Cookie
    }
}
