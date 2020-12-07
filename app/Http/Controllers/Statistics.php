<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class Statistics extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $statistics = Redis::get('statistics');

        if (!$statistics) {
            return response()->json(['message' => 'No statistics have yet been calculated']);
        }

        return response()->json(json_decode($statistics));
    }
}
