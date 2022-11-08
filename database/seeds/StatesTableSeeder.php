<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'id' => 1,
                'iso' => 12,
                'letter' => 'AC',
                'population' => 816687,
                'slug' => 'acre',
                'title' => 'Acre',
            ),
            1 => 
            array (
                'id' => 2,
                'iso' => 27,
                'letter' => 'AL',
                'population' => 3358963,
                'slug' => 'alagoas',
                'title' => 'Alagoas',
            ),
            2 => 
            array (
                'id' => 3,
                'iso' => 13,
                'letter' => 'AM',
                'population' => 4001667,
                'slug' => 'amazonas',
                'title' => 'Amazonas',
            ),
            3 => 
            array (
                'id' => 4,
                'iso' => 16,
                'letter' => 'AP',
                'population' => 782295,
                'slug' => 'amapa',
                'title' => 'Amapá',
            ),
            4 => 
            array (
                'id' => 5,
                'iso' => 29,
                'letter' => 'BA',
                'population' => 15276566,
                'slug' => 'bahia',
                'title' => 'Bahia',
            ),
            5 => 
            array (
                'id' => 6,
                'iso' => 23,
                'letter' => 'CE',
                'population' => 8963663,
                'slug' => 'ceara',
                'title' => 'Ceará',
            ),
            6 => 
            array (
                'id' => 7,
                'iso' => 53,
                'letter' => 'DF',
                'population' => 2977216,
                'slug' => 'distrito-federal',
                'title' => 'Distrito Federal',
            ),
            7 => 
            array (
                'id' => 8,
                'iso' => 32,
                'letter' => 'ES',
                'population' => 3973697,
                'slug' => 'espirito-santo',
                'title' => 'Espírito Santo',
            ),
            8 => 
            array (
                'id' => 9,
                'iso' => 52,
                'letter' => 'GO',
                'population' => 6695855,
                'slug' => 'goias',
                'title' => 'Goiás',
            ),
            9 => 
            array (
                'id' => 10,
                'iso' => 21,
                'letter' => 'MA',
                'population' => 6954036,
                'slug' => 'maranhao',
                'title' => 'Maranhão',
            ),
            10 => 
            array (
                'id' => 11,
                'iso' => 31,
                'letter' => 'MG',
                'population' => 20997560,
                'slug' => 'minas-gerais',
                'title' => 'Minas Gerais',
            ),
            11 => 
            array (
                'id' => 12,
                'iso' => 50,
                'letter' => 'MS',
                'population' => 2682386,
                'slug' => 'mato-grosso-do-sul',
                'title' => 'Mato Grosso do Sul',
            ),
            12 => 
            array (
                'id' => 13,
                'iso' => 51,
                'letter' => 'MT',
                'population' => 3305531,
                'slug' => 'mato-grosso',
                'title' => 'Mato Grosso',
            ),
            13 => 
            array (
                'id' => 14,
                'iso' => 15,
                'letter' => 'PA',
                'population' => 8272724,
                'slug' => 'para',
                'title' => 'Pará',
            ),
            14 => 
            array (
                'id' => 15,
                'iso' => 25,
                'letter' => 'PB',
                'population' => 3999415,
                'slug' => 'paraiba',
                'title' => 'Paraiba',
            ),
            15 => 
            array (
                'id' => 16,
                'iso' => 26,
                'letter' => 'PE',
                'population' => 9410336,
                'slug' => 'pernambuco',
                'title' => 'Pernambuco',
            ),
            16 => 
            array (
                'id' => 17,
                'iso' => 22,
                'letter' => 'PI',
                'population' => 3212180,
                'slug' => 'piaui',
                'title' => 'Piauí',
            ),
            17 => 
            array (
                'id' => 18,
                'iso' => 41,
                'letter' => 'PR',
                'population' => 11242720,
                'slug' => 'parana',
                'title' => 'Paraná',
            ),
            18 => 
            array (
                'id' => 19,
                'iso' => 33,
                'letter' => 'RJ',
                'population' => 16635996,
                'slug' => 'rio-de-janeiro',
                'title' => 'Rio de Janeiro',
            ),
            19 => 
            array (
                'id' => 20,
                'iso' => 24,
                'letter' => 'RN',
                'population' => 3474998,
                'slug' => 'rio-grande-do-norte',
                'title' => 'Rio Grande do Norte',
            ),
            20 => 
            array (
                'id' => 21,
                'iso' => 11,
                'letter' => 'RO',
                'population' => 1787279,
                'slug' => 'rondonia',
                'title' => 'Rondônia',
            ),
            21 => 
            array (
                'id' => 22,
                'iso' => 14,
                'letter' => 'RR',
                'population' => 514229,
                'slug' => 'roraima',
                'title' => 'Roraima',
            ),
            22 => 
            array (
                'id' => 23,
                'iso' => 43,
                'letter' => 'RS',
                'population' => 11286500,
                'slug' => 'rio-grande-do-sul',
                'title' => 'Rio Grande do Sul',
            ),
            23 => 
            array (
                'id' => 24,
                'iso' => 42,
                'letter' => 'SC',
                'population' => 6910553,
                'slug' => 'santa-catarina',
                'title' => 'Santa Catarina',
            ),
            24 => 
            array (
                'id' => 25,
                'iso' => 28,
                'letter' => 'SE',
                'population' => 2265779,
                'slug' => 'sergipe',
                'title' => 'Sergipe',
            ),
            25 => 
            array (
                'id' => 26,
                'iso' => 35,
                'letter' => 'SP',
                'population' => 44749699,
                'slug' => 'sao-paulo',
                'title' => 'São Paulo',
            ),
            26 => 
            array (
                'id' => 27,
                'iso' => 17,
                'letter' => 'TO',
                'population' => 1532902,
                'slug' => 'tocantins',
                'title' => 'Tocantins',
            ),
        ));
        
        
    }
}