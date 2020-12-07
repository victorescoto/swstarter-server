<?php
namespace App\Services;

interface SWServiceInterface
{
    public function search(string $resource, string $text): ?array;
    public function getResource(string $resource, int $id): ?array;
}
