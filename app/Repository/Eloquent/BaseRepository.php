<?php
namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface{
    protected $model;

    public function __contruct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    public function all(array $columns=['*'], array $relations = []):Collection
    {
        return $this->model->with($relations)->get($columns);
    }
}