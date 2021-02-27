<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'List users',
                'slug' => 'users.list'
            ],
            [
                'name' => 'View user',
                'slug' => 'users.view'
            ],
            [
                'name' => 'Create user',
                'slug' => 'users.create'
            ],
            [
                'name' => 'Update user',
                'slug' => 'users.update'
            ],
            [
                'name' => 'Delete user',
                'slug' => 'users.delete'
            ],
        ];
        if (count($permissions)) {
            foreach ($permissions as $permission) {
                if (!Permission::where('slug', $permission['slug'])->count()) {
                    Permission::create($permission);
                }
            }
        }

        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin'
            ],
            [
                'name' => 'Common',
                'slug' => 'common'
            ],
        ];
        if (count($roles)) {
            foreach ($roles as $role) {
                if (!Role::where('slug', $role['slug'])->count()) {
                    $create = Role::create($role);
                    if ($create && $create->slug === 'admin') {
                        $permissions = Permission::all();
                        if (count($permissions)) {
                            $create->permissions()->attach($permissions);
                        }
                    }
                } else {
                    $update = Role::where('slug', $role['slug'])->first();
                    if ($update && $update->slug === 'admin') {
                        $update->permissions()->detach();
                        $permissions = Permission::all();
                        if (count($permissions)) {
                            $update->permissions()->attach($permissions);
                        }
                    }
                }
            }
        }

        $users = [
            [
                'name' => 'Administrator',
                'email' => 'contato@fabricioprabelo.com.br',
                'password' => bcrypt(env('AUTH_PASSWORD', '123456')),
                'is_activated' => true,
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Common',
                'email' => 'common@fabricioprabelo.com.br',
                'password' => bcrypt(env('AUTH_PASSWORD', '123456')),
                'is_activated' => false,
                'email_verified_at' => Carbon::now(),
            ],
        ];
        if (count($users)) {
            foreach ($users as $user) {
                if (!User::where('email', $user['email'])->count()) {
                    $create = User::create($user);
                    if ($create && $create->email === 'contato@fabricioprabelo.com.br') {
                        $roles = Role::all();
                        if (count($roles)) {
                            $create->roles()->detach();
                            $create->roles()->attach($roles);
                        }
                    }
                } else {
                    $update = User::where('email', $user['email'])->first();
                    if ($update && $update->email === 'contato@fabricioprabelo.com.br') {
                        $roles = Role::all();
                        if (count($roles)) {
                            $update->roles()->detach();
                            $update->roles()->attach($roles);
                        }
                    }
                }
            }
        }
    }
}
