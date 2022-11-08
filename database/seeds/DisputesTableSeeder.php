<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DisputesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('disputes')->truncate();
        DB::table('disputes')->insert([
            [
                'dispute_type' => 'provider',
                'dispute_name' => 'Usuário não familiarizado com a rota e a rota alterada',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'dispute_type' => 'provider',
                'dispute_name' => 'Usuário arrogante e rude',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'dispute_type' => 'provider',
                'dispute_name' => 'Valor do passageiro não pago',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],            
            [
                'dispute_type' => 'user',
                'dispute_name' => "Eu não me senti seguro durante o passeio",
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'dispute_type' => 'user',
                'dispute_name' => 'Motorista agressivo ou mal educado',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'dispute_type' => 'user',
                'dispute_name' => 'Motorista tomou rota longa e incorreta',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'dispute_type' => 'user',
                'dispute_name' => 'Motorista atrasado',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'dispute_type' => 'user',
                'dispute_name' => 'O motorista mudou de rota e cobrou uma quantia extra',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
