<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Group has these roles: orgainzer and collaborator
        $role = Role::create(['name' => 'Group Organizer']);
        $role = Role::create(['name' => 'Group Collaborator']);

        // permission for record module
        $permission = Permission::create(['name' => 'list records']);
        $permission = Permission::create(['name' => 'create records']);
        $permission = Permission::create(['name' => 'view records']);
        $permission = Permission::create(['name' => 'edit records']);
        $permission = Permission::create(['name' => 'delete records']);

        // permission for budget module
        $permission = Permission::create(['name' => 'list budget']);
        $permission = Permission::create(['name' => 'create budget']);
        $permission = Permission::create(['name' => 'view budget']);
        $permission = Permission::create(['name' => 'edit budget']);
        $permission = Permission::create(['name' => 'delete budget']);

        // permission for expense sharing module
        $permission = Permission::create(['name' => 'list group']);
        $permission = Permission::create(['name' => 'create group']);
        $permission = Permission::create(['name' => 'view group']);
        $permission = Permission::create(['name' => 'edit group']);
        $permission = Permission::create(['name' => 'delete group']);

        // permission for in-group module
        $permission = Permission::create(['name' => 'list participant']);
        $permission = Permission::create(['name' => 'add participant']);
        $permission = Permission::create(['name' => 'view participant']);
        $permission = Permission::create(['name' => 'edit participant']);
        $permission = Permission::create(['name' => 'remove participant']);
    }
}
