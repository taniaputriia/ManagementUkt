<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('@adminpolsri.')
        ]);

        $data = [
            [
                'name' => 'Bagian Keuangan',
            ],
            [
                'name' => 'Mahasiswa',
            ],
            [
                'name' => 'Admin KPA',
            ],
            [
                'name' => 'Wakil Direktur II',
            ],
        ];

        foreach ($data as $item) {
            $role =  Role::create($item);
            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);
        }
        $user->assignRole([1]);
    }
}
