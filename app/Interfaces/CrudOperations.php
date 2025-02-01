<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface CrudOperations
{
    public function create(Model|Role|Permission $model, array $data);
    public function read(Model $model, int $id);
    public function update(Model $model, array $data);
    public function delete(Model $model, array $ids);
}