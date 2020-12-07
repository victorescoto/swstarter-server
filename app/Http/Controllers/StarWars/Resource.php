<?php

namespace App\Http\Controllers\StarWars;

use App\Http\Controllers\Controller;
use App\Serializers\SWSerializerInterface;
use App\Services\SWServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class Resource extends Controller
{
    /**
     * @param App\Services\SWServiceInterface $apiService
     * @param App\Serializers\SWSerializerInterface $serializer
     * @param string $resource
     * @param string $search
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(
        SWServiceInterface $apiService,
        SWSerializerInterface $serializer,
        string $resource,
        int $id
    ): JsonResponse {
        try {
            $result = $apiService->getResource($resource, $id);
            return response()->json($serializer->serialize($result));
        } catch (Throwable $ex) {
            dd($ex);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
