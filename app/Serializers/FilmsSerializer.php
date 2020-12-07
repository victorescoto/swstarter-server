<?php
namespace App\Serializers;

use Illuminate\Support\Arr;

class FilmsSerializer extends AbstractSWSerializer
{
    /**
     * @param array $film
     * @return array
     */
    protected function serializeItem(array $film): array
    {
        $film = Arr::prepend($film, $this->getResourceId($film), 'id');

        $film['url'] = $this->replaceBaseURL($film['url']);

        $film['characters'] = array_map([$this, 'replaceBaseURL'], $film['characters']);
        $film['planets'] = array_map([$this, 'replaceBaseURL'], $film['planets']);
        $film['starships'] = array_map([$this, 'replaceBaseURL'], $film['starships']);
        $film['vehicles'] = array_map([$this, 'replaceBaseURL'], $film['vehicles']);
        $film['species'] = array_map([$this, 'replaceBaseURL'], $film['species']);

        return $film;
    }
}
