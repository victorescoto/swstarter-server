<?php
namespace App\Serializers;

use Illuminate\Support\Str;

abstract class AbstractSWSerializer
{
    /**
     * @param array $resource
     * @return int
     */
    protected function getResourceId(array $resource): int
    {
        return (int) (string) Str::of($resource['url'])->basename();
    }

    /**
     * @param string $url
     * @return string
     */
    protected function replaceBaseURL(string $url): string
    {
        return (string) Str::of($url)->replace(env('STAR_WARS_API_URL'), env('APP_URL'));
    }
}
