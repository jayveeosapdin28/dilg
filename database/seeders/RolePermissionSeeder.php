<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin' => [
                'access user',
                'insert user',
                'create user',
                'edit user',
                'update user',
                'delete user',
                'view user',

                'access document',
                'insert document',
                'create document',
                'edit document',
                'update document',
                'delete document',
                'view document',

                'access task',
                'insert task',
                'create task',
                'edit task',
                'update task',
                'delete task',
                'view task',

                'access case',
                'insert case',
                'create case',
                'edit case',
                'update case',
                'delete case',
                'view case',

                'access event',
                'insert event',
                'create event',
                'edit event',
                'update event',
                'delete event',
                'view event',

                'access rank',
                'insert rank',
                'create rank',
                'edit rank',
                'update rank',
                'delete rank',
                'view rank',

                'access chat',
                'insert chat',
                'create chat',
                'edit chat',
                'update chat',
                'delete chat',
                'view chat',
            ],

            'Admin' => [
                'access user',
                'insert user',
                'create user',
                'edit user',
                'update user',
                'delete user',
                'view user',

                'access document',
                'insert document',
                'create document',
                'edit document',
                'update document',
                'delete document',
                'view document',

                'access task',
                'insert task',
                'create task',
                'edit task',
                'update task',
                'delete task',
                'view task',

                'access case',
                'insert case',
                'create case',
                'edit case',
                'update case',
                'delete case',
                'view case',

                'access event',
                'insert event',
                'create event',
                'edit event',
                'update event',
                'delete event',
                'view event',

                'access rank',
                'insert rank',
                'create rank',
                'edit rank',
                'update rank',
                'delete rank',
                'view rank',

                'access chat',
                'insert chat',
                'create chat',
                'edit chat',
                'update chat',
                'delete chat',
                'view chat',



            ],

            'User' => [
                'access user',
                'insert user',
                'create user',
                'edit user',
                'update user',
                'delete user',
                'view user',

                'access document',
                'insert document',
                'create document',
                'edit document',
                'update document',
                'delete document',
                'view document',

                'access task',
                'insert task',
                'create task',
                'edit task',
                'update task',
                'delete task',
                'view task',

                'access case',
                'insert case',
                'create case',
                'edit case',
                'update case',
                'delete case',
                'view case',

                'access event',
                'insert event',
                'create event',
                'edit event',
                'update event',
                'delete event',
                'view event',

                'access rank',
                'insert rank',
                'create rank',
                'edit rank',
                'update rank',
                'delete rank',
                'view rank',

                'access chat',
                'insert chat',
                'create chat',
                'edit chat',
                'update chat',
                'delete chat',
                'view chat',
            ],

        ];
        foreach ($roles as $role => $permissions) {
            $db_role = Role::where('name', $role)->first();
            if (!$db_role) {
                // CREATE NEW ROLE
                $db_role = Role::create(['name' => $role]);
            }
            // ADD PERMISSION
            foreach ($permissions as $permission) {
                $new_permission = Permission::where('name', $permission)->first();
                if (!$new_permission) {
                    $new_permission = Permission::create([
                        'name' => $permission
                    ]);
                }
                if (!$db_role->hasPermissionTo($permission)) {
                    $db_role->givePermissionTo($permission);
                }
            }
        }

        $super_admin = User::where('email', 'super-admin@admin.com')->first();
        if (!is_null($super_admin)) {
            $super_admin->assignRole('Super Admin');
        }
    }
}
