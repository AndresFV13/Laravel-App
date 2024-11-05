<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Crea los roles
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'usuario']);
        
        // Asigna roles a los usuarios si existen
        $user1 = User::find(1);
        if ($user1) {
            $user1->assignRole($role1);
        }
        
        $user2 = User::find(2);
        if ($user2) {
            $user2->assignRole($role2);
        }
    }
}

