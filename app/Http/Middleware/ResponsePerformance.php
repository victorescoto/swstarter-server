<?php

namespace App\Http\Middleware;

use Closure;
use Faker\Provider\Uuid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class ResponsePerformance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, JsonResponse $response)
    {
        $responseData = $response->getData();

        Redis::set('request:' . Uuid::uuid(), json_encode([
            'date' => now(),
            'executionTime' => microtime(true) - LARAVEL_START,
            'path' => $request->path(),
            'resultsReturned' => count($responseData->results ?? []),
            'isSuccessful' => $response->isSuccessful(),
            'status' => $response->status(),
        ]));
    }
}
