<?php
namespace App\Serializers;

interface SWSerializerInterface
{
    /**
     * @param array $resources
     * @return array
     */
    public function serialize(array $resources): array;
}
