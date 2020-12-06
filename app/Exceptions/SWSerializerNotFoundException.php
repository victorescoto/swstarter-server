<?php

namespace App\Exceptions;

use Exception;

class SWSerializerNotFoundException extends Exception
{
    public function __construct($resource)
    {
        parent::__construct("Serializer not found for resource: {$resource}");
    }
}
