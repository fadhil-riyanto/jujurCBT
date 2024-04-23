<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\CurrentSessionTrait;
use App\Enum;

class EnsureUsersOnStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use CurrentSessionTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $this->cookie_deserialize($request);

        if ($this->cookie_role == Enum\RoleSessionEnum::Student) {
            return $next($request);
        } else {
            throw new \App\Exceptions\InvalidRoleRoute();
        }


        
    }
}
