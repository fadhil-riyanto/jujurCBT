<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;


use App\Enum;

trait CheckSessionTrait {
    public $req;
    public function CheckSession(Request $req) {
        $this->req = $req;
    } 

    private function getCookieFromReq(): ?string
    {
        // dd($this->req->cookie("login_status"));
        // dd(Crypt::decrypt(Cookie::get('login_status'), false));
        return $this->req->cookie("login_status");
    }

    public function isLogged(bool $need_decrypt_cookie = false): int {
        // dd($this->getCookieFromReq());
        if ($need_decrypt_cookie) {
            try{
                $decrypted = \Illuminate\Cookie\CookieValuePrefix::remove(
                        \Crypt::decrypt($this->req->cookie("login_status"), false)
                );
            } catch (\Illuminate\Contracts\Encryption\DecryptException) {
                $decrypted = false;
            }
            
        } else {
            $decrypted = $this->getCookieFromReq();
        }

        if ($decrypted == true) {
            // dd($decrypted);
            return Enum\SessionStatus::LOG_IN;
        }
        return Enum\SessionStatus::LOGGED_OUT;
    }
}