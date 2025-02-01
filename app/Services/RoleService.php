<?php

namespace App\Services;

use App\Repositories\ModelRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    private $modelRepo;
    private $model;

    public function __construct()
    {
        $this->modelRepo = new ModelRepository;
        $this->model = new Role();
    }

    public function getData($filters)
    {
        $data = [
            'roles' => $this->getRoles($filters),
            'permissions' => Permission::get()->groupBy('module'),
            'permissions_count' => Permission::all()->count()
        ];
        return $data;
    }

    public function create($request)
    {
        $data = $request->safe()->only(['name']);
        $data = array_merge($data, $request->except(['name', 'permissions']));
        $role = $this->modelRepo->create($this->model, $data);
        $role->syncPermissions($request->permissions);
    }

    public function update($request)
    {
        $data = $request->except('permissions');
        $role = Role::findById($data['id']);
        $this->modelRepo->update($role, $data);
        $role->syncPermissions($request->permissions);
    }

    public function remove($request)
    {
        $this->model->where('id', $request->id)->delete();
    }

    public function changeStatus($request)
    {
        $role = $this->model->findOrFail($request->id);
        $role->status = $role->status === 1 ? 0 : 1;
        $role->save();
    }

    private function getRoles($filters)
    {
        $userRole = get_authorized_user()->roles[0]->name;
        $query = Role::with('permissions:name')
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'LIKE', '%' . $filters['search'] . '%');
            });

        if ($userRole == 'Superadmin') $query->where('name', '!=', 'Superadmin');
        if ($userRole == 'Administrator' || $userRole == 'Admin') $query->where([
            ['name', '!=', 'Superadmin'],
            ['id', '!=', get_authorized_user()->id]
        ]);

        return $query->orderBy('id', 'asc')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }
}