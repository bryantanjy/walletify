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

        // Create permissions for account module
        $accountPermissions = [
            'create account', 'view account', 'edit account', 'delete account',
        ];

        // Create permissions for record module
        $recordPermissions = [
            'create record', 'view record', 'edit record', 'delete record',
        ];

        // Create permissions for budget module
        $budgetPermissions = [
            'create budget', 'view budget', 'edit budget', 'delete budget',
        ];

        // Create permissions for expense sharing module
        $groupPermissions = [
            'create group', 'view group', 'edit group', 'delete group',
        ];

        // Create permissions for in-group module
        $participantPermissions = [
            'send group invitation', 'view participant', 'edit participant', 'remove participant',
        ];

        // Create permissions for statistics module
        $statisticsPermissions = [
            'view statistics', 'view expense', 'view income',
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

        foreach ($participantPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $organizer->givePermissionTo($permission);
        }


        // Assign specific permissions to the collaborator role
        $collaborator->givePermissionTo([
            'create record', 'view record', 'edit record', 'delete record', 'view budget', 'view participant',
        ]);
    }
}
