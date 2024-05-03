<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\CheckSessionTrait;
use Illuminate\Support\Facades\Crypt;

class EnsureSession
{
    use CheckSessionTrait;

    protected Request $request;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $this->request = $request;


        if ($request->path() === "login" || $request->path() === "api/auth") {
            return $next($request);
        } else {
            if ($this->isLogged(true)) {
                return $next($request);
            } else {
                if (explode("/", $request->path())[0] === "api") {
                    return response([
                        "log2user_session_state" => "expired"
                    ]);
                } else {
                    return redirect("/login");
                }
                
            }
        }
        
    }
}
