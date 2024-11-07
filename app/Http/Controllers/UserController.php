<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('listaroles.index')->with('success', 'Usuario eliminado correctamente');
    }
}
