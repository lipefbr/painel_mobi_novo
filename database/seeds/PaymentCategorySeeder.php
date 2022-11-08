<?php

use Illuminate\Database\Seeder;

use App\PaymentCategory as Category;


class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        *   Despesas
        */

        Category::firstOrCreate([
            'name'      => 'Pagamento de Comissão',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#9b72ba'
        ]);

        $d1 = Category::firstOrCreate([
            'name'      => 'Alimentação',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#ef9a9a'
        ]);

        $d2 = Category::firstOrCreate([
            'name'      => 'Assinaturas e serviços',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#d32f2f'
        ]);

        $d3 = Category::firstOrCreate([
            'name'      => 'Bares e restaurantes',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#f06292'
        ]);        

        $d4 = Category::firstOrCreate([
            'name'      => 'Casa',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#c2185b'
        ]);

        $d5 = Category::firstOrCreate([
            'name'      => 'Compras',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#880e4f'
        ]);

        $d6 = Category::firstOrCreate([
            'name'      => 'Cuidados pessoais',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#ce93d8'
        ]);

        $d7 = Category::firstOrCreate([
            'name'      => 'Dívidas e empréstimos',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#ba68c8'
        ]);

        $d8 = Category::firstOrCreate([
            'name'      => 'Educação',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#7b1fa2'
        ]);

        $d9 = Category::firstOrCreate([
            'name'      => 'Família e filhos',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#ff4081'
        ]);

        $d10 = Category::firstOrCreate([
            'name'      => 'Devoluções',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#9575cd'
        ]);
        
        $d11 = Category::firstOrCreate([
            'name'      => 'Investimentos',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#90caf9'
        ]);

        $d12 = Category::firstOrCreate([
            'name'      => 'Lazer e hobbies',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#1e88e5'
        ]);

        $d13 = Category::firstOrCreate([
            'name'      => 'Mercado',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#b388ff'
        ]);

        $d14= Category::firstOrCreate([
            'name'      => 'Presentes e doações',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#283593'
        ]);


        $d15= Category::firstOrCreate([
            'name'      => 'Roupas',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#81d4fa'
        ]);

        $d16= Category::firstOrCreate([
            'name'      => 'Saúde',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#039be5'
        ]);

        $d17 = Category::firstOrCreate([
            'name'      => 'Trabalho',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#b2ebf2'
        ]);

        $d18 = Category::firstOrCreate([
            'name'      => 'Transporte',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#4dd0e1'
        ]);


        $d18 = Category::firstOrCreate([
            'name'      => 'Viagem',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#00acc1'
        ]);

        $d19 = Category::firstOrCreate([
            'name'      => 'Compras de mercadorias',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#0097a7'
        ]);


        $d20 = Category::firstOrCreate([
            'name'      => 'Comissões',
            'type'      => 1,
            'blocked'   => true,
            'color'     => '#18ffff'
        ]);

        $d21 = Category::firstOrCreate([
            'name'              => 'Salários',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#00b8d4'
        ]);

        $d22 = Category::firstOrCreate([
            'name'              => 'Adiantamento',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#b2dfdb'
        ]);

        $d23 = Category::firstOrCreate([
            'name'              => 'Férias',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#4db6ac'
        ]);

        $d24 = Category::firstOrCreate([
            'name'              => '13º Salário',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#00897b'
        ]);

        $d25 = Category::firstOrCreate([
            'name'              => 'INSS',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#004d40'
        ]);

        $d26 = Category::firstOrCreate([
            'name'              => 'FGTS',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#00b0ff'
        ]);

        $d27 = Category::firstOrCreate([
            'name'              => 'IRRF',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#c8e6c9'
        ]);

        $d28 = Category::firstOrCreate([
            'name'              => 'Vale Transporte',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#81c784'
        ]);

        $d29 = Category::firstOrCreate([
            'name'              => 'Seguro',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#43a047'
        ]);

        $d30 = Category::firstOrCreate([
            'name'              => 'Aluguel',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#2e7d32'
        ]);

        $d31 = Category::firstOrCreate([
            'name'              => 'Água',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#00c853'
        ]);

        $d32= Category::firstOrCreate([
            'name'              => 'Energia',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffeb3b'
        ]);

        $d33 = Category::firstOrCreate([
            'name'              => 'Material de Escritório',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffff00'
        ]);

        $d34 = Category::firstOrCreate([
            'name'              => 'IPTU',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#fbc02d'
        ]);

        $d35 = Category::firstOrCreate([
            'name'              => 'Manutenção de Imobilizado',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffd600'
        ]);

        $d36 = Category::firstOrCreate([
            'name'              => 'Contabilidade',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffe082'
        ]);


        $d37 = Category::firstOrCreate([
            'name'              => 'Advogados',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffa000'
        ]);

        $d38 = Category::firstOrCreate([
            'name'              => 'Segurança',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffab00'
        ]);


        $d39 = Category::firstOrCreate([
            'name'              => 'Limpeza',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffa726'
        ]);

        $d40 = Category::firstOrCreate([
            'name'              => 'Juros Sobre Empréstimos',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#fb8c00'
        ]);

        $d41 = Category::firstOrCreate([
            'name'              => 'Multas',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#e65100'
        ]);

        $d42 = Category::firstOrCreate([
            'name'              => 'Pagamento de Empréstimos',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ff6d00'
        ]);

        $d43 = Category::firstOrCreate([
            'name'              => 'Tarifas Bancárias',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#f4511e'
        ]);



        /* Impostos */

        $d45 = Category::firstOrCreate([
            'name'              => 'IOF',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ff6e40'
        ]);

        $d46 = Category::firstOrCreate([
            'name'              => 'ICMS',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#607d8b'
        ]);

        $d47= Category::firstOrCreate([
            'name'              => 'IPI',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#455a64'
        ]);


        $d48 = Category::firstOrCreate([
            'name'              => 'PIS/PASEP',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ffd180'
        ]);


        $d49 = Category::firstOrCreate([
            'name'              => 'COFINS',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#7b1fa2'
        ]);

        $d50 = Category::firstOrCreate([
            'name'              => 'IRPJ',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#d500f9'
        ]);


        $d51 = Category::firstOrCreate([
            'name'              => 'Contribuição Social',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#880e4f'
        ]);

        $d52 = Category::firstOrCreate([
            'name'              => 'ISS',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#c62828'
        ]);


        $d53 = Category::firstOrCreate([
            'name'              => 'Fornecedor',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#9c27b0'
        ]);


        $d54 = Category::firstOrCreate([
            'name'              => 'Outras Despesas',
            'type'              => 1,
            'blocked'           => true,
            'color'             => '#ad1457'
        ]);




        /*
        *   Receitas
        */

        
        $r1 = Category::firstOrCreate([
            'name'      => 'Comissão',
            'type'      => 2,
            'blocked'   => true,
            'color'     => '#90caf9'
        ]);

        /*

        $r2 = Category::firstOrCreate([
            'name'              => 'Exames',
            'type'              => 2,
            'blocked'           => true,
            'color'             => '#c5e1a5'
        ]);
        */
        


        $r3 = Category::firstOrCreate([
            'name'              => 'Serviços Prestados',
            'type'              => 2,
            'blocked'           => true,
            'color'             => '#00acc1'
        ]);
        
        $r4 = Category::firstOrCreate([
            'name'              => 'Dividendos Recebidos',
            'type'              => 2,
            'blocked'           => true,
            'color'             => '#81c784'
        ]);     

        $r5 = Category::firstOrCreate([
            'name'              => 'Juros de Aplicações',
            'type'              => 2,
            'blocked'           => true,
            'color'             => '#fdd835'
        ]);
        
        $r6 = Category::firstOrCreate([
            'name'      => 'Empréstimos Bancários',
            'type'      => 2,
            'blocked'   => true,
            'color'     => '#00897b'
        ]);


        $r7 = Category::firstOrCreate([
            'name'              => 'Reembolso de Despesas',
            'type'              => 2,
            'blocked'           => true,
            'color'             => '#cddc39'
        ]);   

        $r8 = Category::firstOrCreate([
            'name'              => 'Venda de Ativos',
            'type'              => 2,
            'blocked'           => true,
            'color'             => '#ffcc80'
        ]);     
        

        $r9 = Category::firstOrCreate([
            'name'      => 'Salário',
            'type'      => 2,
            'blocked'   => true,
            'color'     => '#aed581'
        ]);


        $r10 = Category::firstOrCreate([
            'name'      => 'Outras receitas',
            'type'      => 2,
            'blocked'   => true,
            'color'     => '#1de9b6'
        ]);

    }
}
