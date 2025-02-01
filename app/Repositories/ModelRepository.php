<?php 

namespace App\Repositories;
use App\Interfaces\CrudOperations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModelRepository implements CrudOperations
{
    public function create(Model|Role|Permission $model, array $data)
    {
        return $model->create($data);
    }

    public function read(Model $model, int $id)
    {
        return $model->findOrFail($id);
    }

    public function update(Model $model, array $data)
    {
        foreach ($data as $key => $value) {
            $model[$key] = $value;
        }

        $model->save();
    }

    public function delete(Model $model, array $ids)
    {
        $model->destroy($ids);
    }
}