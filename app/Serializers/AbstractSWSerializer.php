<?php
namespace App\Serializers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class AbstractSWSerializer implements SWSerializerInterface
{
    /**
     * @param array $item
     * @return array
     */
    protected abstract function serializeItem(array $item): array;

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
        return (string) Str::of($url)->replace(env('STAR_WARS_API_URL'), env('APP_URL') . '/api');
    }

    /**
     * @param array $items
     * @return array
     */
    public function serialize(array $items): array
    {
        if (Arr::has($items, 'results')) {
            return $this->serializeSearchResults($items);
        }

        return $this->serializeItem($items);
    }

    /**
     * @param array $items
     * @return array
     */
    protected function serializeSearchResults(array $items): array
    {
        if ($items['next']) {
            $items['next'] = $this->replaceBaseURL($items['next']);
        }

        if ($items['previous']) {
            $items['previous'] = $this->replaceBaseURL($items['previous']);
        }

        foreach ($items['results'] as &$item) {
            $item = $this->serializeItem($item);
        }

        return $items;
    }
}
