<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequestForm;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $filters = request()->all();
        $data = $this->roleService->getData($filters);
        return Inertia::render('Module/Roles', $data);
    }

    public function create(RoleRequestForm $request)
    {
        $this->roleService->create($request);
        return redirect()->route('roles.index')->with('response', 'success');
    }

    public function update(Request $request)
    {
        if ($request->has('id')) {
            $this->roleService->update($request);
            return redirect()->route('roles.index')->with('response', 'success');
        }
    }

    public function remove(Request $request)
    {
        if ($request->has('id')) {
            $this->roleService->remove($request);
            return redirect()->route('roles.index')->with('response', 'success');
        }
    }

    public function changeStatus(Request $request)
    {
        if ($request->has('id')) {
            $this->roleService->changeStatus($request);
            return redirect()->route('roles.index')->with('response', 'success');
        }
    }
    
}
