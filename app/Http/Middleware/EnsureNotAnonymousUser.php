<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits;

class EnsureNotAnonymousUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use Traits\CheckSessionTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $this->request = $request;

        if ($this->isLogged($need_decrypt_cookie = false)) { // because at routing layer, we dont need to decrypt cookie
            return $next($request);
        } else {
            return redirect("/login");
        }
        
    }
}
