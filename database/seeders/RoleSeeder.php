<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'super admin'],
            ['name' => 'RBT'],
            ['name' => 'Subscriptions'],
            ['name' => 'Digital Media'],
            ['name' => 'Social Media'],
            ['name' => 'Multimedia'],
            ['name' => 'Development'],
            ['name' => 'IT'],
            ['name' => 'Legal'],
            ['name' => 'CEO Assistant'],
            ['name' => 'Content'],
            ['name' => 'Quality'],
            ['name' => 'RBT Upload'],
            ['name' => 'Reports'],
            ['name' => 'Finance'],
            ['name' => 'Ceo'],
            ['name' => 'Acount'],
        ];

        foreach ($roles as $role) Role::firstOrCreate($role, $role);
    }
}
