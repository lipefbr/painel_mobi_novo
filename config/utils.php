<?php


return [

    'status_default' => [
        1 => 'Ativo',
        2 => 'Inativo'
    ],
    
    'sexo' => [
        1 => 'Não Informado',
        2 => 'Masculino',
        3 => 'Feminino', 
        4 => 'Outros',
    ],
  	
  	/*
     * array de estados do Brasil
     */
    'state_sigle' => [
        "AC"    =>  "AC", 
        "AL"    =>  "AL", 
        "AM"    =>  "AM", 
        "AP"    =>  "AP",
        "BA"    =>  "BA",
        "CE"    =>  "CE",
        "DF"    =>  "DF",
        "ES"    =>  "ES",
        "GO"    =>  "GO",
        "MA"    =>  "MA",
        "MT"    =>  "MT",
        "MS"    =>  "MS",
        "MG"    =>  "MG",
        "PA"    =>  "PA",
        "PB"    =>  "PB",
        "PR"    =>  "PR",
        "PE"    =>  "PE",
        "PI"    =>  "PI",
        "RJ"    =>  "RJ",
        "RN"    =>  "RN",
        "RO"    =>  "RO",
        "RS"    =>  "RS",
        "RR"    =>  "RR",
        "SC"    =>  "SC",
        "SE"    =>  "SE",
        "SP"    =>  "SP",
        "TO"    =>  "TO"
    ],
    'estados' => [
        "AC"    =>  "Acre", 
        "AL"    =>  "Alagoas", 
        "AM"    =>  "Amazonas", 
        "AP"    =>  "Amapá",
        "BA"    =>  "Bahia",
        "CE"    =>  "Ceará",
        "DF"    =>  "Distrito Federal",
        "ES"    =>  "Espírito Santo",
        "GO"    =>  "Goiás",
        "MA"    =>  "Maranhão",
        "MT"    =>  "Mato Grosso",
        "MS"    =>  "Mato Grosso do Sul",
        "MG"    =>  "Minas Gerais",
        "PA"    =>  "Pará",
        "PB"    =>  "Paraíba",
        "PR"    =>  "Paraná",
        "PE"    =>  "Pernambuco",
        "PI"    =>  "Piauí",
        "RJ"    =>  "Rio de Janeiro",
        "RN"    =>  "Rio Grande do Norte",
        "RO"    =>  "Rondônia",
        "RS"    =>  "Rio Grande do Sul",
        "RR"    =>  "Roraima",
        "SC"    =>  "Santa Catarina",
        "SE"    =>  "Sergipe",
        "SP"    =>  "São Paulo",
        "TO"    =>  "Tocantins"
    ],

    'payment_cycle' => [
        1   => 'Mensal',
        3   => 'Trimestral',
        6   => 'Semestral', 
        12  => 'Anual'
    ],

    'form_of_payment' => [
        1 => 'Dinheiro',
        2 => 'Deposito/Transferência',
        3 => 'Boleto',
        4 => 'Cartão', 
        5 => 'Carnê',
    ],


    'account_type' => [
        1 => 'Conta corrente',
        2 => 'Conta poupança/Investimento',
        3 => 'Outros',
    ],

    'status_amount_color' => [
        0 => '#546e7a',
        1 => '#0277bd',
        2 => '#fbc02d',
        3 => '#ef6c00',
        4 => '#ff6f00',
        5 => '#bf360c'
    ], 

    'status_amount' => [
        1 => 'Completo',
        2 => 'Pendente/Processando',
        3 => 'Cancelado',
        4 => 'Rejeitado',
    ],


    'service_type_vehicle' => [
        1 => 'MOTO',
        2 => 'CARRO',
    ],


];