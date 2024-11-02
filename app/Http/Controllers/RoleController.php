<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('listaroles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('listaroles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('listaroles.index')->with('success', 'Rol creado correctamente');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('listaroles.index')->with('success', 'Rol actualizado correctamente');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('listaroles.index')->with('success', 'Rol eliminado correctamente');
    }
}

