<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $role = Role::where('name', 'admin')->firstOrFail();

            DB::table('users')->insert([
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'user_name' => 'admin',
                    'cell_phone' => '+8801790635944',
                    'password' => bcrypt('password'),
                    'remember_token' => Str::random(60),
                    'role_id' => $role->id,
                ], [
                    'name' => 'mahmud',
                    'email' => 'mahmud@admin.com',
                    'user_name' => 'mahmud',
                    'cell_phone' => '+8801790635943',
                    'password' => bcrypt('password'),
                    'remember_token' => Str::random(60),
                    'role_id' => $role->id,
                ], [
                    'name' => 'Baker',
                    'email' => 'baker@admin.com',
                    'user_name' => 'baker',
                    'cell_phone' => '+8801790635940',
                    'password' => bcrypt('password'),
                    'remember_token' => Str::random(60),
                    'role_id' => $role->id,
                ]
            ]);
        }
    }
}
