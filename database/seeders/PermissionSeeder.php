<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for record module
        $recordPermissions = [
            'list records', 'create records', 'view records', 'edit records', 'delete records',
        ];

        // Create permissions for budget module
        $budgetPermissions = [
            'list budget', 'create budget', 'view budget', 'edit budget', 'delete budget',
        ];

        // Create permissions for expense sharing module
        $groupPermissions = [
            'list group', 'create group', 'view group', 'edit group', 'delete group',
        ];

        // Create permissions for in-group module
        $participantPermissions = [
            'list participant', 'add participant', 'view participant', 'edit participant', 'remove participant',
        ];

        // Group has these roles: organizer and collaborator
        $organizer = Role::create(['name' => 'Group Organizer']);
        $collaborator = Role::create(['name' => 'Group Collaborator']);

        // Assign all permissions to the organizer role
        foreach ($recordPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $organizer->givePermissionTo($permission);
        }

        foreach ($budgetPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $organizer->givePermissionTo($permission);
        }

        foreach ($groupPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $organizer->givePermissionTo($permission);
        }

        foreach ($participantPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $organizer->givePermissionTo($permission);
        }

        // Assign specific permissions to the collaborator role
        $collaborator->givePermissionTo([
            'list records', 'view records', 'list budget', 'view budget',
            'list group', 'view group', 'list participant', 'view participant',
        ]);
    }
}
