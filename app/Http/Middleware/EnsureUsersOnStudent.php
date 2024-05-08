<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\CurrentSessionTrait;
use App\Enum;

use App\Repositories;

class EnsureUsersOnStudent
{
    protected Request $request;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use CurrentSessionTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $siswa_account_db = new Repositories\SiswaAccountRepository();
        $this->request = $request;
        
        $this->cookie_deserialize($request);

        if ($this->cookie_role == Enum\RoleSessionEnum::Student) {
            if (!$siswa_account_db->showBlockStatus($this->cookie_identity)) {
                return $next($request);
            } else {
                return redirect("/blokir");
            }
            
        } else {
            throw new \App\Exceptions\InvalidRoleRoute();
        }


        
    }
}
