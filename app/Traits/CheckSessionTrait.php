<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;


use App\Enum;

trait CheckSessionTrait {
    private function getCookieFromReq(): ?string
    {
        // dd($this->req->cookie("login_status"));
        // dd(Crypt::decrypt(Cookie::get('login_status'), false));
        return unserialize($this->request->cookie("login_data"))["status"];
    }

    public function isLogged(bool $need_decrypt_cookie = false): int {
        // dd($this->getCookieFromReq());
        if ($need_decrypt_cookie) {
            try{

                $decrypted = unserialize(\Illuminate\Cookie\CookieValuePrefix::remove(
                    \Crypt::decrypt($this->request->cookie("login_data"), false)
                ))["status"];
                

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