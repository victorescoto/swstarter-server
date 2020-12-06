<?php

namespace Tests\Unit\SWService;

use App\Services\SWService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SearchPeopleTest extends TestCase
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
                    "name" => "Yoda",
                    "height" => "66",
                    "mass" => "17",
                    "hair_color" => "white",
                    "skin_color" => "green",
                    "eye_color" => "brown",
                    "birth_year" => "896BBY",
                    "gender" => "male",
                    "homeworld" => "http://swapi.dev/api/planets/28/",
                    "films" => [],
                    "species" => [],
                    "vehicles" => [],
                    "starships" => [],
                    "created" => "2014-12-15T12:26:01.042000Z",
                    "edited" => "2014-12-20T21:17:50.345000Z",
                    "url" => "http://swapi.dev/api/people/20/",
                ],
            ],
        ], 200));

        $this->service = new SWService();
    }

    /**
     * @return void
     */
    public function testSearchPeopleShouldReturnSuccessfully(): void
    {
        $response = $this->service->search('people', 'foo');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'http://swapi.dev/api/people/?search=foo';
        });

        $this->assertIsArray($response);

        $this->assertArrayHasKey('count', $response);
        $this->assertArrayHasKey('next', $response);
        $this->assertArrayHasKey('previous', $response);
        $this->assertArrayHasKey('results', $response);

        $this->assertNotEmpty($response['results']);
    }
}
