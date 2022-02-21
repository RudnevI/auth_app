<?php

namespace App\Http\Middleware;

use App\Http\Service\TokenService;
use Closure;
use Exception;


class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
            TokenService::validateToken($request, $next);
    }
}
