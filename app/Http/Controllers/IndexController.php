<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CheckSessionTrait;

class IndexController extends Controller
{
    use CheckSessionTrait;

    public function IndexController(Request $req)
    {
        $this->CheckSession($req);
        if ($this->isLogged()) {
            return redirect("/dashboard");
        } else {
            return redirect("/login");
        }
    }
}
