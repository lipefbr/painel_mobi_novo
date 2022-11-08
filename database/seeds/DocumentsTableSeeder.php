<?php

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->truncate();
        DB::table('documents')->insert([
            [
                'name' => 'CNH',
                'type' => 'DRIVER',
            ],
            [
                'name' => 'Licenciamento do Veículo',
                'type' => 'VEHICLE',
            ]
        ]);
    }
}
