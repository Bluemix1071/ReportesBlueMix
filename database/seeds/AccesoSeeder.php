<?php

use Illuminate\Database\Seeder;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accesos')->insert([
            'uscodi'=> '100',
            'username' => 'XDD',
            'password' => bcrypt('123456')
        ]);
    }
}
