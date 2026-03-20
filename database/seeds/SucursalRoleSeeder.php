<?php

use Illuminate\Database\Seeder;

class SucursalRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'sucursal', 'guard_name' => 'web']);
    }
}
