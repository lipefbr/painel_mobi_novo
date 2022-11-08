<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class ReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('reasons')->truncate();
        DB::table('reasons')->insert([
            [
                'type' => 'PROVIDER',
                'reason' => 'Demorei muito para chegar ao ponto de captação',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'PROVIDER',
                'reason' => 'Trafégo pesado/Engarrafamento',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'PROVIDER',
                'reason' => 'Usuário escolheu o local errado',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'PROVIDER',
                'reason' => 'Meu motivo não está listado',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'PROVIDER',
                'reason' => 'Usuário indisponível',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'USER',
                'reason' => 'Meu motivo não está listado',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'USER',
                'reason' => 'Não foi possível entrar em contato com o motorista',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'USER',
                'reason' => 'Esperava um tempo de espera mais curto',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'USER',
                'reason' => 'Motorista se nega a vir me buscar',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'USER',
                'reason' => 'Motorista se nega a ir ao destino',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
