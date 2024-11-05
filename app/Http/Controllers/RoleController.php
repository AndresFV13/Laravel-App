<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

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

    public function editUserRoles(User $user)
    {
        // Obtén todos los roles disponibles
        $roles = Role::all();
        
        // Obtén los roles asignados al usuario
        $userRoles = $user->roles->pluck('id')->toArray();
    
        return view('editUserRoles.index', compact('user', 'roles', 'userRoles'));
    }
    
    public function updateUserRoles(Request $request, User $user)
    {
        // Valida la solicitud
        $request->validate([
            'roles' => 'array', // Acepta múltiples roles
            'roles.*' => 'exists:roles,id', // Asegúrate de que los IDs de roles existan
        ]);
    
        // Sincroniza los roles asignados al usuario
        $user->syncRoles($request->roles);
    
        return redirect()->route('listaroles.index')->with('success', 'Roles actualizados correctamente');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('listaroles.index')->with('success', 'Rol eliminado correctamente');
    }

    public function listarUsuariosConRoles()
    {
        $usuarios = \App\Models\User::with('roles')->get();
        return view('listaroles.index', compact('usuarios'));
    }
}

