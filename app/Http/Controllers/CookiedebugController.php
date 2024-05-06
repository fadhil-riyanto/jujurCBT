<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;

class CookiedebugController extends Controller
{
    use Traits\CurrentSessionTrait;
    protected Request $request;
    //
    public function debug(Request $request) {

        $this->request = $request;
        // return dd($request->cookie("debugtwo") === true);
        // dd(unserialize($request->cookie("login_data")));
        // return response("okok")->cookie(cookie("keys",  serialize([
        //     "key1" => "val1",
        //     "key2" => "val2"
        // ])));
        

        // $this->cookie_deserialize($request);
        // dd($this);
        return $request->session()->get("key");
    }
}
