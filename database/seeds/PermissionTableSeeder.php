<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


use App\Group;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Schema::disableForeignKeyConstraints();

    	DB::table('model_has_roles')->truncate();

      DB::table('permissions')->truncate();

      $admin = Role::find(1);


       /* Painel */
      $painel = Group::firstOrCreate([
        'name' =>'Painel'
      ]); 

      Permission::firstOrCreate([
          'group_id' => $painel->id,
          'name' =>'dashboard-menus',
          'guard_name' => 'admin',
          'display_name' => 'Visualizar Dashboard'
        ]);

      Permission::firstOrCreate([
          'group_id' => $painel->id,
          'name' =>'dashboard-cards',
          'guard_name' => 'admin',
          'display_name' => 'Visualizar Cards Em Dashboard'
        ]);

      Permission::firstOrCreate([
          'group_id' => $painel->id,
          'name' =>'dashboard-recent-trip',
          'guard_name' => 'admin',
          'display_name' => 'Visualizar Viagens Recentes'
        ]);

      Permission::firstOrCreate([
          'group_id' => $painel->id,
          'name' =>'dashboard-recent-trip-details',
          'guard_name' => 'admin',
          'display_name' => 'Detalhar Viagens Recentes'
        ]);




      /* Despachante */
      $despachante = Group::firstOrCreate([
        'name' =>'Despachante'
      ]);     


      Permission::firstOrCreate([
          'group_id' => $despachante->id,
          'name' =>'dispatcher-panel',
          'guard_name' => 'admin',
          'display_name' => 'Painel Despachante'
        ]);

       Permission::firstOrCreate([
          'group_id' => $despachante->id,
          'name' =>'dispatcher-panel-add',
          'guard_name' => 'admin',
          'display_name' => 'Realizar Despache Manual'
        ]);



      /* Disputa */
      $dispute = Group::firstOrCreate([
        'name' =>'Disupta'
      ]);     


      Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-menu',
          'guard_name' => 'admin',
          'display_name' => 'Menu Disputa'
        ]);

      Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-list',
          'guard_name' => 'admin',
          'display_name' => 'Listar Disputas'
        ]);


       Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Disputas'
        ]);

       Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Disputas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Disputas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-type',
          'guard_name' => 'admin',
          'display_name' => 'Ver Tipos Disputas'
        ]);



        Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-type-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Tipos Disputas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-type-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Tipos Disputas'
        ]);

        Permission::firstOrCreate([
          'group_id' => $dispute->id,
          'name' =>'dispute-type-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Tipos Disputas'
        ]);


      /* Mapas */
      $maps = Group::firstOrCreate([
        'name' =>'Mapas'
      ]);  


       Permission::firstOrCreate([
          'group_id' => $maps->id,
          'name' =>'god-eye',
          'guard_name' => 'admin',
          'display_name' => 'Mapa Olho de Deus'
        ]);


       /* Passageiros */
      $passenger = Group::firstOrCreate([
        'name' =>'Passageiros'
      ]);  


       Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Passageiros'
        ]);


      Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Lista de Passageiros'
        ]);


      Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-create',
          'guard_name' => 'admin',
          'display_name' => 'Adicionar Passageiros'
        ]);

      Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Passageiros'
        ]);

       Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-details',
          'guard_name' => 'admin',
          'display_name' => 'Ver Detalhes de Passageiros'
        ]);


       Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-wallet',
          'guard_name' => 'admin',
          'display_name' => 'Ver Saldo de Passageiros'
        ]);

       Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-history',
          'guard_name' => 'admin',
          'display_name' => 'Ver Histórico de Viagens em Passageiros'
        ]);


       Permission::firstOrCreate([
          'group_id' => $passenger->id,
          'name' =>'user-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Passageiros'
        ]);



       /* Motoristas */
      $providers = Group::firstOrCreate([
        'name' =>'Motoristas'
      ]);  


       Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Motoristas'
        ]);


       Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Lista de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-status',
          'guard_name' => 'admin',
          'display_name' => 'Ver Status de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-wallet',
          'guard_name' => 'admin',
          'display_name' => 'Ver Saldo de Motoristas'
        ]);


       Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-create',
          'guard_name' => 'admin',
          'display_name' => 'Adicionar Motoristas'
        ]);


       Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-details',
          'guard_name' => 'admin',
          'display_name' => 'Ver Detalhes de Motoristas'
        ]);

        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-active',
          'guard_name' => 'admin',
          'display_name' => 'Ativar/Desativar Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-history',
          'guard_name' => 'admin',
          'display_name' => 'Ver Histórico de Motoristas'
        ]);


         Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-services',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Serviços de Motoristas'
        ]);


         Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-service-add',
          'guard_name' => 'admin',
          'display_name' => 'Adicionar Serviços a Motoristas'
        ]);


         Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-service-update',
          'guard_name' => 'admin',
          'display_name' => 'Autalizar Serviços a Motoristas'
        ]);

        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-service-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Serviços de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-documents',
          'guard_name' => 'admin',
          'display_name' => 'Ver documentos de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-document-edit',
          'guard_name' => 'admin',
          'display_name' => 'Aprovar documentos de Motoristas'
        ]);

        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-document-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir/Recusar documentos de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-wallet-withdrawals',
          'guard_name' => 'admin',
          'display_name' => 'Ver Histórico de Saques de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-wallet-withdraw-approve',
          'guard_name' => 'admin',
          'display_name' => 'Aprovar Saques de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-wallet-withdraw-recuse',
          'guard_name' => 'admin',
          'display_name' => 'Recusar Saques de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $providers->id,
          'name' =>'provider-reviews',
          'guard_name' => 'admin',
          'display_name' => 'Ver Aavaliações de Motoristas'
        ]);




       /* Franquias */
      $fleets = Group::firstOrCreate([
        'name' =>'Franquias'
      ]);  


       Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Franquias'
        ]);


         Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Franquias'
        ]);

       Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Franquias'
        ]);

       Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Franquias'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Franquias'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-manage',
          'guard_name' => 'admin',
          'display_name' => 'Gerenciar Franquias'
        ]);

         Permission::firstOrCreate([
          'group_id' => $fleets->id,
          'name' =>'fleet-providers',
          'guard_name' => 'admin',
          'display_name' => 'Listar Motoristas da Franquia'
        ]);


        $fleets_services = Group::firstOrCreate([
          'name' =>'Serviços',
          'parent_id' => $fleets->id
        ]);  

        Permission::firstOrCreate([
          'group_id' => $fleets_services->id,
          'name' =>'service-types-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Serviços da Franquia'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_services->id,
          'name' =>'service-types-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Serviços'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_services->id,
          'name' =>'service-types-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Serviços'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_services->id,
          'name' =>'service-types-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Serviços'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_services->id,
          'name' =>'service-types-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Serviços'
        ]);


        $fleets_peak_hour = Group::firstOrCreate([
          'name' =>'Horário de Pico',
          'parent_id' => $fleets->id
        ]);  


         Permission::firstOrCreate([
          'group_id' => $fleets_peak_hour->id,
          'name' =>'peak-hour-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Horários de Pico'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_peak_hour->id,
          'name' =>'peak-hour-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Horários de Pico'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_peak_hour->id,
          'name' =>'peak-hour-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Horários de Pico'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_peak_hour->id,
          'name' =>'peak-hour-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Horários de Pico'
        ]);



        $fleets_promocode = Group::firstOrCreate([
          'name' =>'Cupons',
          'parent_id' => $fleets->id
        ]);  



        Permission::firstOrCreate([
          'group_id' => $fleets_promocode->id,
          'name' =>'promocodes-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Cupons'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_promocode->id,
          'name' =>'promocodes-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Cupons'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_promocode->id,
          'name' =>'promocodes-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Cupons'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_promocode->id,
          'name' =>'promocodes-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Cupons'
        ]);


        $fleets_documents = Group::firstOrCreate([
          'name' =>'Documentos Extras',
          'parent_id' => $fleets->id
        ]); 


        Permission::firstOrCreate([
          'group_id' => $fleets_documents->id,
          'name' =>'fleet-doc-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Documentos Extras'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_documents->id,
          'name' =>'fleet-doc-create',
          'guard_name' => 'admin',
          'display_name' => 'Adicionar Documento Extra'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_documents->id,
          'name' =>'fleet-doc-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Documento Extra'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_documents->id,
          'name' =>'fleet-doc-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Documento Extra'
        ]);


         $fleets_wallet = Group::firstOrCreate([
          'name' =>'Carteira',
          'parent_id' => $fleets->id
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet',
          'guard_name' => 'admin',
          'display_name' => 'Ver Saldo Total Da Carteira'
        ]);



        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-disponible',
          'guard_name' => 'admin',
          'display_name' => 'Ver Saldo Dispnível Da Carteira'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-withdraw',
          'guard_name' => 'admin',
          'display_name' => 'Solicitar Saque'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-withdraw-history',
          'guard_name' => 'admin',
          'display_name' => 'Histórico de Saques'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-withdraw-attachment',
          'guard_name' => 'admin',
          'display_name' => 'Ver Anexos em Saque'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-withdraw-cancel',
          'guard_name' => 'admin',
          'display_name' => 'Cancelar Saque'
        ]);


        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-withdraw-send',
          'guard_name' => 'admin',
          'display_name' => 'Confirmar Enviar Saque'
        ]);

        Permission::firstOrCreate([
          'group_id' => $fleets_wallet->id,
          'name' =>'fleet-wallet-withdraw-recuse',
          'guard_name' => 'admin',
          'display_name' => 'Recusar Saque'
        ]);


        /* Documentos */
        $documents = Group::firstOrCreate([
          'name' =>'Documentos'
        ]);  


       Permission::firstOrCreate([
          'group_id' => $documents->id,
          'name' =>'documents-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Documentos'
        ]);



       Permission::firstOrCreate([
          'group_id' => $documents->id,
          'name' =>'documents-list',
          'guard_name' => 'admin',
          'display_name' => 'Listar Documentos'
        ]);


       Permission::firstOrCreate([
          'group_id' => $documents->id,
          'name' =>'documents-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Documentos'
        ]);


       Permission::firstOrCreate([
          'group_id' => $documents->id,
          'name' =>'documents-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Documentos'
        ]);


       Permission::firstOrCreate([
          'group_id' => $documents->id,
          'name' =>'documents-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Documentos'
        ]);


          /* Motivos de Cancelamento */
        $reasons = Group::firstOrCreate([
          'name' =>'Motivos de Cancelamento'
        ]);  


       Permission::firstOrCreate([
          'group_id' => $reasons->id,
          'name' =>'cancel-reasons-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Motivos de Cancelamento'
        ]);


       Permission::firstOrCreate([
          'group_id' => $reasons->id,
          'name' =>'cancel-reasons-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Motivos de Cancelamento'
        ]);

       Permission::firstOrCreate([
          'group_id' => $reasons->id,
          'name' =>'cancel-reasons-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Motivos de Cancelamento'
        ]);

       Permission::firstOrCreate([
          'group_id' => $reasons->id,
          'name' =>'cancel-reasons-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Motivos de Cancelamento'
        ]);


       Permission::firstOrCreate([
          'group_id' => $reasons->id,
          'name' =>'cancel-reasons-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Motivos de Cancelamento'
        ]);


        /* Financeiro */
        $financial = Group::firstOrCreate([
          'name' =>'Financeiro'
        ]);  

        Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Financeiro'
        ]);

       Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-overview',
          'guard_name' => 'admin',
          'display_name' => 'Ver Visão Geral'
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-withdrawals-fleet',
          'guard_name' => 'admin',
          'display_name' => 'Ver Solicitação de Saques de Franquia'
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-withdrawals-driver',
          'guard_name' => 'admin',
          'display_name' => 'Ver Solicitação de Saques de Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-withdrawals-details',
          'guard_name' => 'admin',
          'display_name' => 'Detalhar Perfil do Solicitante'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-withdrawals-send',
          'guard_name' => 'admin',
          'display_name' => 'Enviar Saque'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial->id,
          'name' =>'financial-withdrawals-send',
          'guard_name' => 'admin',
          'display_name' => 'Recusar Saque'
        ]);

         $financial_releases = Group::firstOrCreate([
          'name' =>'Lançamentos',
          'parent_id' => $financial->id
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases',
          'guard_name' => 'admin',
          'display_name' => 'Ver Lançamentos de Viagens'
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-sum-bar',
          'guard_name' => 'admin',
          'display_name' => 'Ver Barra de Somatórios: [TOTAL, RECEITAS, CANCELADO, COMISSÕES]'
        ]);



        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-trip',
          'guard_name' => 'admin',
          'display_name' => 'Ver Lançamentos de Viagens e Serviços'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-admins',
          'guard_name' => 'admin',
          'display_name' => 'Ver Lançamentos Administrativos'
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-new-realease',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Novo Lançamento'
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-transfer',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Transferências'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-transfer-driver',
          'guard_name' => 'admin',
          'display_name' => 'Realizar Transferências Para Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-transfer-fleet',
          'guard_name' => 'admin',
          'display_name' => 'Realizar Transferências Para Franquias'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-transfer-user',
          'guard_name' => 'admin',
          'display_name' => 'Realizar Transferências Para Passageiros'
        ]);

        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Lançamentos de Receitas ou Despesas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Lançamentos de Receitas ou Despesas'
        ]);


       Permission::firstOrCreate([
          'group_id' => $financial_releases->id,
          'name' =>'financial-releases-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Lançamentos de Receitas ou Despesas'
        ]);


       /* Guia Outros */
        $others = Group::firstOrCreate([
          'name' =>'Outros'
        ]);  

        Permission::firstOrCreate([
          'group_id' => $others->id,
          'name' => 'registrations-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Cadastros'
        ]);

        Permission::firstOrCreate([
          'group_id' => $others->id,
          'name' => 'other-button',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão Outros'
        ]);


        $lost_item = Group::firstOrCreate([
          'name' =>'Itens Perdidos',
          'parent_id' => $others->id
        ]);

        Permission::firstOrCreate([
          'group_id' => $lost_item->id,
          'name' => 'lost-item-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Itens Perdidos'
        ]);


        Permission::firstOrCreate([
          'group_id' => $lost_item->id,
          'name' => 'lost-item-create',
          'guard_name' => 'admin',
          'display_name' => 'Adicionar Item Perdido'
        ]);


        Permission::firstOrCreate([
          'group_id' => $lost_item->id,
          'name' => 'lost-item-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Item Perdido'
        ]);


         Permission::firstOrCreate([
          'group_id' => $others->id,
          'name' => 'other-reveiws',
          'guard_name' => 'admin',
          'display_name' => 'Ver Avaliações'
        ]);


        Permission::firstOrCreate([
          'group_id' => $others->id,
          'name' => 'cms-pages',
          'guard_name' => 'admin',
          'display_name' => 'Ver Páginas Estáticas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $others->id,
          'name' => 'cms-pages-update',
          'guard_name' => 'admin',
          'display_name' => 'Atualizar Páginas Estáticas'
        ]);


         /* Notificaçoes */
        $notifications = Group::firstOrCreate([
          'name' =>'Notificações'
        ]); 


        $push = Group::firstOrCreate([
          'name' =>'Push',
          'parent_id' => $notifications->id
        ]);

        Permission::firstOrCreate([
          'group_id' => $push->id,
          'name' => 'custom-push',
          'guard_name' => 'admin',
          'display_name' => 'Ver Bottão notifiações Push'
        ]);


        Permission::firstOrCreate([
          'group_id' => $push->id,
          'name' => 'custom-push-driver',
          'guard_name' => 'admin',
          'display_name' => 'Criar Notificaçoes Push Motoristas'
        ]);


        Permission::firstOrCreate([
          'group_id' => $push->id,
          'name' => 'custom-push-user',
          'guard_name' => 'admin',
          'display_name' => 'Criar Notificaçoes Push Passageiros'
        ]);


        Permission::firstOrCreate([
          'group_id' => $push->id,
          'name' => 'notification-push-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Notificaçoes Push'
        ]);


        $notification = Group::firstOrCreate([
          'name' =>'Notificaçoes/Mensagens',
          'parent_id' => $notifications->id
        ]);

        
        Permission::firstOrCreate([
          'group_id' => $notification->id,
          'name' => 'notification-push-list',
          'guard_name' => 'admin',
          'display_name' => 'Ver Notificaçoes'
        ]);
        
        Permission::firstOrCreate([
          'group_id' => $notification->id,
          'name' => 'notification-push-create',
          'guard_name' => 'admin',
          'display_name' => 'Criar Notificaçoes'
        ]);
        
        Permission::firstOrCreate([
          'group_id' => $notification->id,
          'name' => 'notification-push-edit',
          'guard_name' => 'admin',
          'display_name' => 'Editar Notificaçoes'
        ]);

        Permission::firstOrCreate([
          'group_id' => $notification->id,
          'name' => 'notification-push-delete',
          'guard_name' => 'admin',
          'display_name' => 'Excluir Notificaçoes'
        ]);


         /* Configuracoes */
        $settings = Group::firstOrCreate([
          'name' =>'Configurações'
        ]); 


        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings',
          'guard_name' => 'admin',
          'display_name' => 'Ver Botão de Configurações'
        ]);


        $settings_payments = Group::firstOrCreate([
          'name' =>'Pagamento',
          'parent_id' => $settings->id
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings_payments->id,
          'name' => 'payment-settings',
          'guard_name' => 'admin',
          'display_name' => 'Ver Configurações de Pagamento'
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings_payments->id,
          'name' => 'payment-settings-keys',
          'guard_name' => 'admin',
          'display_name' => 'Alterar Chaves de Pagamento'
        ]);


        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-general',
          'guard_name' => 'admin',
          'display_name' => 'Ver Card Configurações gerais'
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-social-links',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Links e Rede Social'
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-social-login',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Login Redes Social'
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-search-algo',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Algoritimo de Pesquisa'
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-maps-keys',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Mapas e Chaves'
        ]);

        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-email',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia E-mail'
        ]);


        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-push',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Notificações Push'
        ]);



        Permission::firstOrCreate([
          'group_id' => $settings->id,
          'name' => 'settings-other',
          'guard_name' => 'admin',
          'display_name' => 'Ver Guia Outros'
        ]);



        /* Perfil */
        $profile = Group::firstOrCreate([
          'name' =>'Perfil'
        ]);

       Permission::firstOrCreate([
          'group_id' =>  $profile->id,
          'name' =>'account-settings',
          'guard_name' => 'admin',
          'display_name' =>'Ver Perfil'
        ]);


       Permission::firstOrCreate([
          'group_id' =>  $profile->id,
          'name' =>'account-update',
          'guard_name' => 'admin',
          'display_name' =>'Atualizar Perfil'
        ]);


       Permission::firstOrCreate([
          'group_id' =>  $profile->id,
          'name' =>'account-update-pass',
          'guard_name' => 'admin',
          'display_name' =>'Atualizar Senha'
        ]);


        /* Usuarios */
        $users = Group::firstOrCreate([
          'name' =>'Usuários'
        ]);     

       Permission::firstOrCreate([
          'group_id' =>  $users->id,
          'name' =>'admin-user-view',
          'guard_name' => 'admin',
          'display_name' =>'Acesso a lista de Usuários'
        ]);

       Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-create',
          'guard_name' => 'admin',
          'display_name' =>'Adicionar Usuários'
        ]);
        
        Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-edit',
          'guard_name' => 'admin',
          'display_name' =>'Editar Usuários'
        ]);

        Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-pass-update',
          'guard_name' => 'admin',
          'display_name' =>'Atualizar Senha de Usuários'
        ]);

        Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-delete',
          'guard_name' => 'admin',
          'display_name' =>'Deletar Usuários'
        ]);
        
        Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-delete-permanent',
          'guard_name' => 'admin',
          'display_name' =>'Deletar Usuários Permanentemente'
        ]);

        Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-deleted',
          'guard_name' => 'admin',
          'display_name' =>'Usuários Excluidos'
        ]);

        Permission::firstOrCreate([
          'group_id' => $users->id,
          'name' =>'admin-user-restore',
          'guard_name' => 'admin',
          'display_name' =>'Restaurar Usuários'
        ]);


        /* Papeis */
       $papeis = Group::firstOrCreate([
          'name' =>'Papéis'
        ]);
 

       Permission::firstOrCreate([
          'group_id' => $papeis->id,
          'name' =>'role-view',
          'guard_name' => 'admin',
          'display_name' =>'Visualizar Papéis'
        ]);

       Permission::firstOrCreate([
          'group_id' => $papeis->id,
          'name' =>'role-create',
          'guard_name' => 'admin',
          'display_name' =>'Criar Papel'
        ]);

       Permission::firstOrCreate([
          'group_id' => $papeis->id,
          'name' =>'role-edit',
          'guard_name' => 'admin',
          'display_name' =>'Eitar Papel'
        ]);

        Permission::firstOrCreate([
          'group_id' => $papeis->id,
          'name' =>'role-delete',
          'guard_name' => 'admin',
          'display_name' =>'Deletar Papel'
        ]);


        /* Log */
       
        $log = Group::firstOrCreate([
          'name' =>'Log'
        ]);


        Permission::firstOrCreate([
          'group_id' => $log->id,
          'name' =>'log-view',
          'guard_name' => 'admin',
          'display_name' =>'Visualizar Log'
        ]);

        Permission::firstOrCreate([
          'group_id' =>  $log->id,
          'name' =>'log-delete',
          'guard_name' => 'admin',
          'display_name' =>'Deletar Log'
        ]);



        $admin_permissions = Permission::select('id')->get();

        $admin->syncPermissions($admin_permissions->toArray());


        $sub_admin = Role::find(2);
        $admin->syncPermissions([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,25,26,27,28,29,30,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,142,143,144,145,146,147]);


        $fleet = Role::where('name', 'FLEET')->first();

        //$fleet->permissions()->detach();
        //$fleet->permissions()->attach( $permission );
        

        $fleet->syncPermissions([1,2,3,4,5,6,7,8,9,10,11,12,16,25,26,27,28,29,30,32,33,34,35,36,37,38,39,40,41,45,46,47,49,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,87,88,89,91,94,95,96,98,106,107,108,109,110,132,133]);


        $dispatcher = Role::where('name', 'DISPATCHER')->first();

        //$dispatcher_permissions = Permission::select('id')->whereIn('id', [4,5,91,93])->get();
        //$dispatcher->syncPermissions($dispatcher_permissions->toArray());
        
        $dispatcher->syncPermissions([1,3,4,5,6,16,46,47]);

        $dispute = Role::where('name', 'DISPUTE')->first();

        //$dispute_permissions = Permission::select('id')->whereIn('id', [6,7,8,9,91,93])->get();
        //$dispute->syncPermissions($dispute_permissions->toArray());
        
        $dispute->syncPermissions([7,8,9,10,12,107,108,109,110,111,133,134,135]);

        $account = Role::where('name', 'ACCOUNT')->first();

        //$account_permissions = Permission::select('id')->whereIn('id', [1,2,3,47,91,93])->get();
        //$account->syncPermissions($account_permissions->toArray());
        
        $account->syncPermissions([1,2,3,46,47,51,69,70,71,72,73,74,87,88,89,91,94,95,96,106,133,134,135]);

        Schema::enableForeignKeyConstraints();


    }
}
