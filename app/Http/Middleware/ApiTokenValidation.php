<?php

namespace App\Http\Middleware;

use App\Helpers\HtmlHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token');

        if (empty($token) || $token !== env('APP_API_TOKEN')) {
            
            return response()->json(['error' => 'Unauthorized'], HtmlHelper::UNAUTHORIZED);
        }

        return $next($request);
    }
}
