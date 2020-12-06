<?php

namespace Tests\Feature;

use App\Services\SWService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Mockery\Expectation;

class SearchPeopleFeatureTest extends TestCase
{
    protected $baseURL = '/api/people/search';

    /**
     * Tests the endpoint URL
     *
     * @return void
     */
    public function testEndpointUrl()
    {
        $response = $this->get("{$this->baseURL}/yoda");
        $response->assertOk();
        $this->assertNotEmpty($response['results']);
    }

    /**
     * Tests the endpoint result when the search is not alphanumeric
     *
     * @return void
     */
    public function testNotAlphaNumericSearchParam()
    {
        $response = $this->get("{$this->baseURL}/@!");
        $response->assertNotFound();
    }

    /**
     * Tests the endpoint result when no results are found
     *
     * @return void
     */
    public function testAnEmptyResult()
    {
        $response = $this->get("{$this->baseURL}/123");
        $response->assertOk();
        $this->assertEmpty($response['results']);
    }

    /**
     * Tests the endpoint result when an exception occurs
     *
     * @return void
     */
    public function testExceptionWhenSearching()
    {
        $this->mock(SWService::class, function ($mock) {
            $mock
                ->shouldReceive('search')
                ->andThrow(new Exception);
        });

        $response = $this->get("{$this->baseURL}/R2D2");
        $response
            ->assertStatus(500)
            ->assertJson(['error' => 'Something went wrong']);
    }
}
