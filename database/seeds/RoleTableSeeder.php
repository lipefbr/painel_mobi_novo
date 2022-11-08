<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            ['name' => 'ADMIN', 'display_name' => 'Super Admin', 'guard_name' => 'admin'],
            ['name' => 'ADMIN', 'display_name' => 'Administrador', 'guard_name' => 'admin'],
            ['name' => 'DISPATCHER', 'display_name' => 'Despachante','guard_name' => 'admin'],
            ['name' => 'DISPUTE', 'display_name' => 'Gerente de Disputa', 'guard_name' => 'admin'],
            ['name' => 'ACCOUNT', 'display_name' => 'Financeiro', 'guard_name' => 'admin'],  
            ['name' => 'FLEET', 'display_name' => 'Franqueado', 'guard_name' => 'admin']          
        ]);
        
        Schema::enableForeignKeyConstraints();
    }
}
