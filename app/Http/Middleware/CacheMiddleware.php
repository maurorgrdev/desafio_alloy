<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET')) {
            $cacheKey = 'api_' . sha1($request->fullUrl());
            
            try {
                if (Cache::has($cacheKey)) {
                    return response()->json(Cache::get($cacheKey));
                }
                
                $response = $next($request);
                
                if ($response->getStatusCode() === 200) {
                    Cache::put($cacheKey, $response->getData(), 300);
                }
                
                return $response;
            } catch (\Exception $e) {
                return $next($request);
            }
        }
        
        return $next($request);
    }
} 