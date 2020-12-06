<?php

namespace App\Http\Controllers\StarWars;

use App\Http\Controllers\Controller;
use App\Serializers\SWSerializerInterface;
use App\Services\SWServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class Search extends Controller
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
        string $search
    ): JsonResponse {
        try {
            $searchResult = $apiService->search($resource, $search);
            return response()->json($serializer->serialize($searchResult));
        } catch (Throwable) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
