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

        // Obtiene los nombres de los roles a partir de sus IDs
        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

        // Sincroniza los roles asignados al usuario usando los nombres
        $user->syncRoles($roleNames);

        return redirect()->route('listaroles.index')->with('success', 'Roles actualizados correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('listaroles.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function listarUsuariosConRoles()
    {
        $usuarios = \App\Models\User::with('roles')->get();
        return view('listaroles.index', compact('usuarios'));
    }

    public function mostrarRoles()
    {
        $roles = Role::all();
        return view('permisos.index', compact('roles'));
    }

    public function eliminarRol($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return to_route('permisos.index');
    }
}

