<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CheckSessionTrait;

class IndexController extends Controller
{
    use CheckSessionTrait;

    protected Request $request;

    public function IndexController(Request $request)
    {
        $this->request = $request;

        if ($this->isLogged()) {
            return redirect("/dashboard");
        } else {
            return redirect("/login");
        }
    }
}
