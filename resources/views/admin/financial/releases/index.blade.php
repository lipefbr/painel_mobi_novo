@extends('admin.layout.app')


@section('styles')

<link href="{{ url('asset/js/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('agroxa/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('asset/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>

<style type="text/css">
    .card-bottom-floating {

        position: sticky;
        bottom: 0%;
        z-index: 200;

    }
</style>

@endsection

@section('title', 'Financeiro | Lançamentos')

@section('content')


<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">



            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-7">

                                <div class="dropdown btn-group">
                                    @can('financial-releases')
                                    <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="https://example.com" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Lançamentos de Viagens
                                    </a>
                                    @endcan
                                    
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
                                        @can('financial-releases')
                                        <a class="dropdown-item" href="{{ route('admin.financial.realeses') }}">Lançamentos de Viagens</a>
                                        @endcan
                                        @can('financial-releases-admins')
                                        <a class="dropdown-item" href="{{ route('admin.financial.realeses') }}?type=admin">Lançamentos Administrativos</a>
                                        @endcan
                                    </div>
                                </div>
                                {{--
                                <div class="dropdown btn-group">
                                    <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="https://example.com" id="dropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Todo Periodo
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink4">
                                        <a class="dropdown-item" href="#">Ultimos 7 Dias</a>
                                        <a class="dropdown-item" href="#">Esse Mês</a>
                                        <a class="dropdown-item" href="#">Todo Periodo</a>
                                        <a class="dropdown-item" href="#">Escolher Periodo</a>
                                    </div>
                                </div>

                                 @if($typeList != 'admin')

                                 <div class="btn-group" id="multiple_fleets">

                                    <select class="select2 form-control select2-multiple"  multiple="multiple" data-placeholder="Filtrar Por Franquias" style="width: 200px !important;">
                                        <optgroup>
                                            <option value="AK">Alaska</option>
                                            <option value="HI">Hawaii</option>
                                        </optgroup>
                                        
                                    </select>

                                </div>

                                @endif

                                 --}}
                                

                            </div>
                           
                            @can('financial-releases-new-realease')
                            <div class="col-sm-5 d-flex justify-content-end">
                                <div class="dropdown ">
                                    <a class="btn btn-primary waves-effect waves-light dropdown-toggle" href="https://example.com" id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Novo Lançamento
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink3">
                                        @can('financial-releases-transfer')
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bs-modal-transference">Transferencia</a>
                                        @endcan
                                        @can('financial-releases-create')
                                        <a class="dropdown-item new-recipe" href="#" data-toggle="modal" data-target=".bs-modal-add-recipe">Receita</a>
                                        <a class="dropdown-item new-expense" data-toggle="modal" data-target=".bs-modal-add-recipe" href="#">Despesa</a>
                                        @endcan
                                    </div>
                                </div>
                            </div> 
                            @endcan   
                        </div> 
                        <br>   

                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Valor Total</th>
                                        @if($typeList != 'admin')
                                        <th scope="col">Comissão</th>
                                        <th scope="col">Forma de Pagamento</th>
                                        @else
                                        <th scope="col">Categoria</th>
                                        @endif
                                        @if($typeList != 'admin')
                                        <th scope="col">Status</th>
                                        @endif
                                        
                                        <th scope="col" width="100">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($releases as $release)
                                    <tr>
                                    @if($typeList == 'admin')
                                        <td>
                                            <svg height="15" width="15">
                                              <circle cx="10" cy="10" r="5" @if($release->type == 'D') fill="red"  @else  fill="green" @endif/> 
                                              </svg> 
                                        </td>
                                        <td>
                                            
                                            {{ $release->transaction_desc }}

                                        </td>
                                        <td>{{ $release->created_at->diffForHumans() }}
                                            <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($release->created_at)) }}</p>
                                        </td>
                                        <td>
                                             {{ currency( $release->amount) }}
                                        </td>
                                        <td>
                                            @if(isset($release->category_id))
                                            <i class="mdi mdi-label" style="color: {{ $release->category->color }}; vertical-align: middle;"></i> {{ $release->category->name }}
                                            @else
                                            #
                                            @endif
                                            
                                        </td>
                                        <td>
                                            @if($release->editable)
                                            <a href="#" class="btn btn-primary btn-sm payment-edit" data-toggle="modal" data-target=".bs-modal-payment-edit" data-id="{{ $release->id }}" data-payment-value='{!! number_format( $release->amount, 2, ",", "." ) !!}'  data-payment-date="{{ $release->payment_date }}"  data-form-of-payment="{{ $release->form_of_payment }}" data-payment-desc="{{ $release->transaction_desc }}" data-payment-type="{{ $release->type }}"  data-category="{{ $release->category->name }}" data-category-id="{{ $release->category_id }}" data-toggle="tooltip" data-original-title="Editar Lançamento" data-placement="left"><i class="mdi mdi-square-edit-outline" style="font-size: 16px;"></i></a>
                                            <a href="{{ route('admin.financial.realeses.payment.delete', $release->id) }}"  class="btn btn-danger btn-sm" data-method="delete" data-long-text="{{ $release->transaction_desc }} - {{ currency( $release->amount) }} (Obs: A ação não poderá ser desfeita)"  data-title="Deseja realmente excluir esse lançamento?" data-toggle="tooltip" data-original-title="Excluir Lançamento" data-placement="top"><i class="mdi mdi-delete-forever" style="font-size: 16px; color: #FFF"></i></a>
                                            @endif
                                        </td>
                                    @else
                                    
                                        <td>
                                            <svg height="15" width="15">
                                              <circle cx="10" cy="10" r="5" @if($payment->payment_type == 1) fill="red"  @else  fill="green" @endif/> 
                                              </svg> 
                                        </td>
                                        <td>
                                            
                                            {{ $release->service_type->name }}

                                        </td>
                                        
                                        <td>{{ $release->created_at->diffForHumans() }}
                                            <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($release->created_at)) }}</p>
                                        </td>
                                        @if($release->paid)
                                        <td>
                                            {{ currency( $release->payment->total) }}
                                        </td>
                                        <td>
                                            {{ currency( $release->payment->commision) }}
                                        </td>

                                        @else
                                        <td>
                                            {{ currency($release->estimated_fare) }}
                                        </td>
                                        <td>
                                            R$0,00
                                        </td>
                                        @endif
                                        <td>
                                            @if($release->payment_mode == "CASH")
                                                DINHEIRO
                                            @elseif($release->payment_mode == "DEBIT_MACHINE")
                                                DÉBITO MÁQUINA
                                            @elseif($release->payment_mode == "VOUCHER")
                                                VOUCHER
                                            @elseif($release->payment_mode == "CARD")
                                                CARTÃO
                                            @else
                                                {{ $release->payment_mode }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($release->paid)
                                                <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> PAGO</span>
                                            @else
                                                <span class="badge badge-danger badge-pill"><i class="mdi mdi-checkbox-blank-circle text-danger"></i> NÃO PAGO</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.requests.show',$release->id)}}" class="btn btn-primary btn-sm">DETALHES</a>
                                        </td>
                                    
                                    @endif
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>


                        </div>
                        @can('financial-releases-sum-bar')
                        <hr>
                        <div class="row" style="margin-left: 6px">
                            <div class="col s3">
                                <p><b>TOTAL</b></p>
                                <p style="color: #039be5"><b>R$ {!! number_format( $releaseTotal, 2, ",", "." ) !!}</b></p>
                            </div>            
                            <div class="col s3">
                                <p><b>RECEITAS</b></p>
                                <p  style="color: #2e7d32"><b>R$  {!! number_format( $releaseRecipe, 2, ",", "." ) !!}</b></p>
                            </div>            
                            <div class="col s3">
                                <p><b>CANCELADO</b></p>
                                <p  style="color: #d84315"><b>R${!! number_format( $releasesCanceled, 2, ",", "." ) !!}</b></p>
                            </div>
                            <div class="col s3">
                                <p><b>COMISSÕES</b></p>
                                <p style="color: #ff9800"><b>R$ {!! number_format( $releaseComission, 2, ",", "." ) !!}</b></p>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@can('financial-releases-sum-bar')
<div class=" card-bottom-floating">
<div class="page-content-wrapper " style="margin-top: 0px">
    <div class="container-fluid">

    <div class="card" style="margin-bottom: 0px; -webkit-box-shadow: 0px -1px 11px -1px rgba(0,0,0,0.33);
            -moz-box-shadow: 0px -1px 11px -1px rgba(0,0,0,0.33);
            box-shadow: 0px -1px 11px -1px rgba(0,0,0,0.33);">
        <div class="card-body" style="width: 100%; padding-bottom: 16px">
            <div class="row" style="margin-left: 6px">
                <div class="col-md-3">
                    <p><b>TOTAL</b></p>
                    <p style="color: #039be5"><b>R$ {!! number_format( $releaseTotal, 2, ",", "." ) !!}</b></p>
                </div>            
                <div class="col-md-3">
                    <p><b>RECEITAS</b></p>
                    <p  style="color: #2e7d32"><b>R$  {!! number_format( $releaseRecipe, 2, ",", "." ) !!}</b></p>
                </div>            
                <div class="col-md-3">
                    <p><b>CANCELADO</b></p>
                    <p  style="color: #d84315"><b>R${!! number_format( $releasesCanceled, 2, ",", "." ) !!}</b></p>
                </div>
                <div class="col-md-3">
                    <p><b>COMISSÕES</b></p>
                    <p style="color: #ff9800"><b>R$ {!! number_format( $releaseComission, 2, ",", "." ) !!}</b></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endcan

<div class="modal fade bs-modal-add-recipe" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                 {!! Form::open(['route' => ['admin.financial.realeses.payment'],  'method' => 'post', 'id' => 'form-create-payment', 'enctype' => 'multipart/form-data']) !!}
                    
                    {!! Form::hidden('payment_type', 2, ['id' => 'create-payment-type']) !!} 
    

                    {!! Form::hidden('category_id', 0, ['id' => 'create-payment-category-id']) !!} 
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="create-payment-title">Nova Receita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body row">
                        <p class="col-sm-12">Dica: Não insira valores que não estão disponíveis no caixa real da empresa.</p>
                    
                        <div class="form-group col-sm-12">
                            <label>Titulo/Descrição</label>
                            <input type="text" class="form-control" name="transaction_desc" required>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Valor</label>
                            <input type="text" for="create-payment-value money" class="form-control money" name="value" value="0,00" required>
                        </div>

                         <div class="form-group col-sm-6">
                            <label>Data</label>
                            <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}"  required>
                        </div>

                         <div class="form-group col-sm-6">
                            <label>Forma</label>
                            {!! Form::select('form_of_payment',config('utils.form_of_payment'), null, [ 'id'=> 'form-of-payment', 'class' => 'form-control select2-single']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Categoria</label>
                            <input type="text" id="create-payment-category" name="category" class="category" required>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                 {!! Form::close() !!} 
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




<div class="modal fade bs-modal-transference" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                 {!! Form::open(['route' => ['admin.financial.realeses.payment.transfer'],  'method' => 'post', 'id' => 'form-create-payment', 'enctype' => 'multipart/form-data']) !!}
                    
                    {!! Form::hidden('payment_type', 2, ['id'    => 'create-payment-type']) !!}
                    {!! Form::hidden('payment_by_type', 'driver', ['id'     => 'payment-transfer-type']) !!} 
    
                    {!! Form::hidden('category_id', 0, ['id' => 'create-payment-category-id']) !!} 
    
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="create-payment-title">Transferência</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body row">
                        <p class="col-sm-12">Obs: ao realizar uma transferência sera criado um debito na conta administrativa e um crédito na conta do destinatário. <span style="color: red">[ A ação não poderá ser desfeita]</span></p>

                         <div class="form-group col-sm-12">
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                @can('financial-releases-transfer-driver')
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" id="tap_tranfer_driver_a" href="#tap_tranfer_driver" role="tab">Motorista</a>
                                </li>
                                @endcan
                                @can('financial-releases-transfer-fleet')
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" id="tap_tranfer_fleet_a"  href="#tap_tranfer_fleet" role="tab">Franquia</a>
                                </li>
                                @endcan
                                @can('financial-releases-transfer-user')
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" id="tap_tranfer_user_a" href="#tap_tranfer_user" role="tab">Passageiro</a>
                                </li>
                                @endcan
                            </ul>


                            <div class="tab-content">
                                    @can('financial-releases-transfer-driver')
                                        <div class="tab-pane active " id="tap_tranfer_driver" role="tabpanel">
                                            <div class="form-group" style="margin-top: 16px">

                                            {!! Form::select('provider', ['' => 'Selecione um destinatário'], null, ['tabindex' => '-1', 'class' => 'select_single form-control paymentDestination']) !!} 

                                            </div>
                                        </div>
                                    @endcan
                                    @can('financial-releases-transfer-fleet')
                                        <div class="tab-pane" id="tap_tranfer_fleet" role="tabpanel">
                                            <div class="form-group" style="margin-top: 16px">    

                                            {!! Form::select('fleet', ['' => 'Selecione um destinatário'], null, ['tabindex' => '-1', 'class' => 'select_single form-control paymentDestination']) !!} 
                                            </div>
                                        </div>
                                    @endcan
                                    @can('financial-releases-transfer-user')
                                        <div class="tab-pane" id="tap_tranfer_user" role="tabpanel">
                                             <div class="form-group" style="margin-top: 16px">    
                                                {!! Form::select('user', ['' => 'Selecione um destinatário'], null, ['tabindex' => '-1', 'class' => 'select_single form-control paymentDestination']) !!} 
                                             </div>
                                        </div>
                                    @endcan
                                    </div>
                        </div>
                    
                        <div class="form-group col-sm-12">
                            <label>Titulo/Descrição</label>
                            <input type="text" class="form-control" name="transaction_desc" required>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Valor</label>
                            <input type="text" for="create-payment-value money" class="form-control money" name="value" value="0,00" required>
                        </div>

                         <div class="form-group col-sm-6">
                            <label>Data</label>
                            <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}" required>
                        </div>

                   
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Realizar Transferência</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                 {!! Form::close() !!} 
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!-- Editar pagamento -->
<div class="modal fade bs-modal-payment-edit" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

    
    {!! Form::open(['route' => ['admin.financial.realeses.payment.update'],  'method' => 'put', 'id' => 'form-payment-edit', 'enctype' => 'multipart/form-data']) !!}

        {!! Form::hidden('payment_id', 0, ['id' => 'edit-payment-payment-id']) !!} 
        {!! Form::hidden('category_id', 0, ['id' => 'edit-payment-category-id']) !!} 

        <div class="modal-header">
            <h5 class="modal-title mt-0" id="edit-payment-title">Nova Receita</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body row">
        
            <div class="form-group col-sm-12">
                <label>Titulo/Descrição</label>
                <input type="text" class="form-control" id="edit-payment-desc" name="transaction_desc" required>
            </div>

            <div class="form-group col-sm-6">
                <label>Valor</label>
                <input type="text" for="create-payment-value money" id="edit-payment-amount" class="form-control money" name="value" value="0,00" required>
            </div>

             <div class="form-group col-sm-6">
                <label>Data</label>
                <input type="date" class="form-control" name="payment_date" id="edit-payment-date" value="{{ date('Y-m-d') }}"  required>
            </div>

             <div class="form-group col-sm-6">
                <label>Forma</label>
                {!! Form::select('form_of_payment',config('utils.form_of_payment'), null, [ 'id'=> 'edit-form-of-payment', 'class' => 'form-control select2-single']) !!}
            </div>

            <div class="form-group col-sm-6">
                <label>Categoria</label>
                <input type="text" id="edit-payment-category" name="category" class="category" required>
            </div>
           
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
    {!! Form::close() !!} 
</div>
</div>
</div>



@endsection

@section('scripts')

<script src="{{ url('asset/js/selectize/js/standalone/selectize.js') }}"></script>
<script src="{{ url('asset/js/maskmoney/jquery.maskMoney.min.js') }}"></script>
<script src="{{ url('asset/js/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ url('agroxa/plugins/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $(".select2").select2({ width: '300px'});


    $(".select2-limiting").select2({
        maximumSelectionLength: 2
    });


    $(".money").maskMoney({ decimal: ",", allowZero: true, thousands: "." }); 

    var recipe =  JSON.parse('{!! $categories_recipe !!}');
    var expense =  JSON.parse('{!! $categories_expense!!}');

    


    var $category_create_payment = $('#create-payment-category').selectize({
      maxItems: 1,
      persist: false,
      placeholder: 'Categoria',
      valueField: 'name',
      labelField: 'color',
      searchField: ['name'],
      options: expense,
      /*
      create: function(input) {
          $category[0].selectize.addOption({id: 0, color: '#000', name: input});
          $('#create-payment-category-name').val(input);
          $('#create-payment-category-id').val(0);

          return {id: 0, color: '#000', name: input}
      },
      */

      onItemRemove: function(v){
         $('#create-payment-category-name').val('');
         $('#create-payment-category-id').val(0);
      },

      onItemAdd: function(value, $item){
        console.log("Categoria adicionada");
      },

      render: {
          item: function(item, escape) {
            console.log(item);

            $('#create-payment-category-id').val(item.id);


            return '<div>' + 
              '<svg height="15" width="15" style="margin-right: 16px"><circle cx="10" cy="10" r="5" fill="'+item.color+'" /></svg>' +
                '<span>' + item.name+ '</span>' +
            '</div>';
          },
          option: function(item, escape) {
             var type  = "de outros";
             if(item.type == 0){
                type = "de outros";
             }else if(item.type == 1){
                type = "de despesas";
             }else if(item.type == 2){
                type = "de receitas";
             }
              
              return '<div>' + 
                '<svg height="15" width="15" style="margin-right: 16px"><circle cx="10" cy="10" r="5" fill="'+item.color+'" /></svg>' +
                  '<span>' + item.name+ '</span><br>' + 
                  '<span style="margin-left: 31px;  font-size: 13px; color: #90a4ae;">' + type+ '</span>'+ 
              '</div>';
          }
      }

  });

     $('.new-recipe').on('click', function(event) {

        $("#form-create-payment")[0].reset();
        $('#create-payment-title').html('Nova Receita');

        $("#create-payment-type").val(2);

        $category_create_payment[0].selectize.clearOptions();
        $category_create_payment[0].selectize.addOption(recipe);

    });

    //Nova despesa
    $('.new-expense').on('click', function(event) {

        $("#form-create-payment")[0].reset();
        $('#create-payment-title').html('Nova Despesa');
        $("#create-payment-type").val(1);

        $category_create_payment[0].selectize.clearOptions();
        $category_create_payment[0].selectize.addOption(expense);

    });



  var $category = $('#edit-payment-category').selectize({
      maxItems: 1,
      persist: false,
      placeholder: 'Categoria',
      valueField: 'name',
      labelField: 'color',
      searchField: ['name'],
      options: expense,

      onItemRemove: function(v){
         $('#edit-payment-category-name-create').val('');
         $('#edit-payment-category-id').val(0);
      },

      onItemAdd: function(value, $item){
        console.log("Categoria adicionada");
      },

      render: {
          item: function(item, escape) {
            $('#edit-payment-category-id').val(item.id);

            return '<div>' + 
              '<svg height="15" width="15" style="margin-right: 16px"><circle cx="10" cy="10" r="5" fill="'+item.color+'" /></svg>' +
                '<span>' + item.name+ '</span>' +
            '</div>';
          },
          option: function(item, escape) {
             var type  = "de outros";
             if(item.type == 0){
                type = "de outros";
             }else if(item.type == 1){
                type = "de despesas";
             }else if(item.type == 2){
                type = "de receitas";
             }
              
              return '<div>' + 
                '<svg height="15" width="15" style="margin-right: 16px"><circle cx="10" cy="10" r="5" fill="'+item.color+'" /></svg>' +
                  '<span>' + item.name+ '</span><br>' + 
                  '<span style="margin-left: 31px;  font-size: 13px; color: #90a4ae;">' + type+ '</span>'+ 
              '</div>';
          }
      }

  });


   $('.payment-edit').on('click', function(event) {

        if($(this).attr('data-payment-type') == 'D'){
            $('#edit-payment-title').html('Editar Despesa');

            $category[0].selectize.clearOptions();
            $category[0].selectize.addOption(expense);
            $category[0].selectize.setValue($(this).attr('data-category'));

        } else {
            $('#edit-payment-title').html('Editar Receita');

            $category[0].selectize.clearOptions();
            $category[0].selectize.addOption(recipe);
            $category[0].selectize.setValue($(this).attr('data-category'));
        }

        $('#edit-payment-desc').val($(this).attr('data-payment-desc'));
        $('#edit-payment-amount').val($(this).attr('data-payment-value'));
        $('#edit-payment-date').val($(this).attr('data-payment-date'));
        $('#edit-form-of-payment').val($(this).attr('data-form-of-payment'));
        $('#edit-payment-payment-id').val($(this).attr('data-id'));

    });




    @can('financial-releases-sum-bar')

    hideAndShowCard();
    $(window).scroll(function(){
        hideAndShowCard();
    });

    function hideAndShowCard(){
        var scrollBottom = $(document).height() - ( $(window).height() + $(window).scrollTop());

        if (scrollBottom < 185) {
            $(".card-bottom-floating").hide();
        } else {
            $(".card-bottom-floating").show();
        }
    }
    @endcan


    $(".select_single").select2({ width: 'element' });

    
    $('#multiple_fleets .selection__rendered').css("width","300px");
    $('#multiple_fleets .select2-selection').css("width","300px");


    var d = 'driver';

    $('#tap_tranfer_fleet_a').on( "click", function(){
        d = 'fleet';
        $('#payment-transfer-type').val(d);
    });

    $('#tap_tranfer_driver_a').on( "click", function(){
        d = 'driver';
        $('#payment-transfer-type').val(d);
    });

    $('#tap_tranfer_user_a').on( "click", function(){
        d = 'user';
        $('#payment-transfer-type').val(d);
    });




     var token      = "{{ csrf_token() }}";
     var url        = "{!! route('admin.financial.realeses.paymentdestination') !!}";
    

        $(".paymentDestination").select2({
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    q: params.term,
                    destination: d,
                    page: params.page
                  };
                },
                processResults: function (data, params) {
                  params.page = params.page || 1;

                  return {
                    results: data,
                    pagination: {
                      more: (params.page * 30) < data.total_count
                    }
                  };
                },
                cache: true
            },

        });


</script>
@endsection