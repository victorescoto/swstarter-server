<?php
namespace App\Serializers;

use Illuminate\Support\Arr;

class PeopleSerializer extends AbstractSWSerializer
{
    /**
     * @param array $person
     * @return array
     */
    public function serializeItem(array $person): array
    {
        $person = Arr::prepend($person, $this->getResourceId($person), 'id');

        $person['homeworld'] = $this->replaceBaseURL($person['homeworld']);
        $person['url'] = $this->replaceBaseURL($person['url']);

        $person['films'] = array_map([$this, 'replaceBaseURL'], $person['films']);
        $person['species'] = array_map([$this, 'replaceBaseURL'], $person['species']);
        $person['vehicles'] = array_map([$this, 'replaceBaseURL'], $person['vehicles']);
        $person['starships'] = array_map([$this, 'replaceBaseURL'], $person['starships']);

        return $person;
    }
}
