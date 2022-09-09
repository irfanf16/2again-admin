<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::exists()){
            DB::table('roles')->insert([
               [
                   'name' => 'Admin'
               ],
               [
                   'name' => 'User'
               ]
            ]);
        }
    }
}
