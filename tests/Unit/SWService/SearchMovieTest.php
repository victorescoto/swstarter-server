<?php

namespace Tests\Unit\SWService;

use App\Service\SWService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SearchMovieTest extends TestCase
{
    private SWService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(fn () => Http::response([
            "count" => 1,
            "next" => null,
            "previous" => null,
            "results" => [
                [
                    "title" => "A New Hope",
                    "episode_id" => 4,
                    "opening_crawl" => "It is a period of civil war.\r\nRebel spaceships, striking",
                    "director" => "George Lucas",
                    "producer" => "Gary Kurtz, Rick McCallum",
                    "release_date" => "1977-05-25",
                    "characters" => [],
                    "planets" => [],
                    "starships" => [],
                    "vehicles" => [],
                    "species" => [],
                    "created" => "2014-12-10T14:23:31.880000Z",
                    "edited" => "2014-12-20T19:49:45.256000Z",
                    "url" => "http://swapi.dev/api/films/1/"
                ],
            ],
        ], 200));

        $this->service = new SWService();
    }

    /**
     * @return void
     */
    public function testSearchMovieShouldReturnSuccessfully(): void
    {
        $response = $this->service->searchMovie('foo');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://swapi.dev/api/films/?search=foo';
        });

        $this->assertIsArray($response);

        $this->assertArrayHasKey('count', $response);
        $this->assertArrayHasKey('next', $response);
        $this->assertArrayHasKey('previous', $response);
        $this->assertArrayHasKey('results', $response);

        $this->assertNotEmpty($response['results']);
    }
}
