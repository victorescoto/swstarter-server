<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class SWService implements SWServiceInterface
{
    protected string $baseURL;

    public function __construct()
    {
        $this->baseURL = env('STAR_WARS_API_URL');
    }

    /**
     * @param string $resource
     * @param string $text
     */
    public function search(string $resource, string $text): ?array
    {
        $response = Http::get("{$this->baseURL}/{$resource}/", ['search' => $text]);
        $response->throw();

        return $response->json();
    }
}
