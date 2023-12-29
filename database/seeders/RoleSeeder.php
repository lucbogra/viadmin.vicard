<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Account Manager']);
        Role::create(['name' => 'Account Owner']);
        Role::create(['name' => 'Member']);

        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@vicards.net',
            'password'  =>  Hash::make('password')
        ]);

        $admin->assignRole('Admin');
    }
}
