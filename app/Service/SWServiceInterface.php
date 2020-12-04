<?php
namespace App\Service;

interface SWServiceInterface
{
    public function searchPeople(string $name): ?array;
    public function searchMovie(string $title): ?array;
}
