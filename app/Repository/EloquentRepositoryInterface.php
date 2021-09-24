<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function create(array $payload): ?model;

    public function all(array $columns = ['*'], array $relations=[]):Collection;
}