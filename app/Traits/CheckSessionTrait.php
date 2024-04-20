<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Enum;

trait CheckSessionTrait {
    public $req;
    public function CheckSession(Request $req) {
        $this->req = $req;
    } 

    public function getCookieFromReq(): ?bool
    {
        return $this->req->cookie("login_status");
    }

    public function isLogged(): int {
        if ($this->getCookieFromReq()) {
            return Enum\SessionStatus::LOG_IN;
        }
        return Enum\SessionStatus::LOGGED_OUT;
    }
}