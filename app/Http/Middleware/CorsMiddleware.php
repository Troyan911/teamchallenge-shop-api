<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedOrigins = ['http://localhost:5173'];
        $origin = $request->headers->get('Origin');

        if (in_array($origin, $allowedOrigins) || true) {
            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            //            $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

            if ($request->getMethod() == 'OPTIONS') {
                $response->headers->set('Access-Control-Allow-Origin', $origin);
                $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

                return $response;
            }

            return $response;
        }

        return $next($request);
    }
}
