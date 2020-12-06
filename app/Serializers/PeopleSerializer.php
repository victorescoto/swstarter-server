<?php
namespace App\Serializers;

use Illuminate\Support\Arr;

class PeopleSerializer extends AbstractSWSerializer implements SWSerializerInterface
{
    public function serialize(array $people): array
    {
        if ($people['next']) {
            $people['next'] = $this->replaceBaseURL($people['next']);
        }

        if ($people['previous']) {
            $people['previous'] = $this->replaceBaseURL($people['previous']);
        }

        foreach ($people['results'] as &$person) {
            $person = Arr::prepend($person, $this->getResourceId($person), 'id');

            $person['homeworld'] = $this->replaceBaseURL($person['homeworld']);
            $person['url'] = $this->replaceBaseURL($person['url']);

            $person['films'] = array_map([$this, 'replaceBaseURL'], $person['films']);
            $person['species'] = array_map([$this, 'replaceBaseURL'], $person['species']);
            $person['vehicles'] = array_map([$this, 'replaceBaseURL'], $person['vehicles']);
            $person['starships'] = array_map([$this, 'replaceBaseURL'], $person['starships']);
        }

        return $people;
    }
}
