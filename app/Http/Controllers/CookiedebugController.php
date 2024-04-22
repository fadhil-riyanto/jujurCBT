<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookiedebugController extends Controller
{
    //
    public function debug(Request $request) {
        return dd($request->cookie("debugtwo") === true);
    }
}
