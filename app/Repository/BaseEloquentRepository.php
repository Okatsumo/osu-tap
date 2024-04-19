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

    /**
     * @throws OperationError
     */
    public function save(array $data = []): void
    {
        try {
            $this->model->create($data);
        } catch (\PDOException $ex) {

            if ($ex->getCode() == 23000)  {
                throw new OperationError('Record already exists', 23000);
            }

            throw new OperationError($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @throws OperationError
     */
    public function get(int $id, array|string $columns = ['*'])
    {
        $data = $this->model->find($id, $columns);

        if (empty($data)) {
            throw new OperationError('item not found', 404);
        }

        return $data;
    }

    public function getLastId(string $orderBy = 'id'): int
    {
        $data = $this
            ->model
            ->orderBy($orderBy, 'desc')
            ->limit(1)
            ->first();

        return $data->id;
    }

    public function update(int $id, array $attributes, array $options = [])
    {
        $this
            ->model
            ->find($id)
            ->update($attributes, $options);
    }
}
