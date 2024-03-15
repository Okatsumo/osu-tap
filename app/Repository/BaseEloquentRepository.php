<?php

namespace App\Repository;

use App\Exceptions\OperationError;
use Illuminate\Database\Eloquent\Model;

class BaseEloquentRepository
{

    protected string $modelClass;
    protected Model $model;

    protected function setModelClass(string $model)
    {
        $this->modelClass = $model;
        $this->model = app($model);
    }

    public function save(array $data = [])
    {
        $this->model->create($data);
    }

    /**
     * @throws OperationError
     */
    public function get(int $id, array|string $columns = ['*'])
    {
        $data = $this->model->find($id, $columns);

        if (empty($data)) {
            throw new OperationError('beatmaps set not found', 404);
        }

        return $data;
    }

    public function getLastId(string $orderBy = 'id'): int
    {
        $beatmapset = $this
            ->model
            ->orderBy($orderBy, 'desc')
            ->limit(1)
            ->first();

        return $beatmapset->id;
    }
}
