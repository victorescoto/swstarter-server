<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;

class SWService implements SWServiceInterface
{
    protected string $baseURL = 'https://swapi.dev/api';

    /**
     * @param string $resource
     * @param string $text
     */
    protected function search(string $resource, string $text): ?array
    {
        $response = Http::get("{$this->baseURL}/{$resource}/", ['search' => $text]);
        $response->throw();

        return $response->json();
    }

    /**
     * @param string $name
     */
    public function searchPeople(string $name): ?array
    {
        return $this->search(resource: 'people', text: $name);
    }

    /**
     * @param string $title
     */
    public function searchMovie(string $title): ?array
    {
        return $this->search(resource: 'films', text: $title);
    }
}
