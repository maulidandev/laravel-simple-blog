<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ["Super Admin", "Admin", "Writer"];

        foreach ($roles as $role)
            Role::create(["name" => $role]);
    }
}
