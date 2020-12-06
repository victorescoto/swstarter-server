<?php
namespace App\Services;

interface SWServiceInterface
{
    public function search(string $resource, string $text): ?array;
}
