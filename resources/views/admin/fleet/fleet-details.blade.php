@extends('admin.layout.app')

@section('title', 'Gestão da Franquia ')

@section('styles')
<link rel="stylesheet" href="{{ asset('asset/css/bootstrap-material-datetimepicker.css') }}" />
<link href="{{ url('asset/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')



<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-header">

                        <div class="row">

                            <div class="col-sm-6 ">
                                <h6 style="margin-bottom: 0px">Detalhes da Franquia</h6>
                            </div>

                            <div class="col-sm-6 d-flex justify-content-end button-items">
                                @can('fleet-edit')
                                <a class="btn btn-primary " href="{{ route('admin.fleet.edit', $fleet->id) }}"> <i class="far fa-edit"></i> @lang('admin.edit')</a>
                                @endcan
                                @can('fleet-delete')
                                <button href="{{ route('admin.fleet.destroy', $fleet->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$fleet->name}}"  class="btn btn-danger" data-title="Deseja realmente excluir essa franquia?"><i class="far fa-trash-alt"></i> @lang('admin.delete')</button>
                                @endcan

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div>
                                    <div class="directory-img float-left mr-4">
                                        <img src="{{img($fleet->logo)}}" alt="" class="thumb-md rounded-circle mr-2"> 
                                    </div>
                                    <p class="text-muted mb-2">
                                        {{$fleet->name }}
                                        <br>
                                        {{ $fleet->city->title }} -  {{ $fleet->city->state->letter }}
                                        <br>
                                    </p>


                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="directory-img float-left mr-4">
                                    <img src="{{img($fleet->admin->picture)}}" alt="" class="thumb-md rounded-circle mr-2"> 
                                </div>
                                <p class="text-muted mb-2">
                                    {{ $fleet->admin->name }}
                                    <br>
                                    {{ $fleet->admin->email }} | {{ $fleet->admin->mobile }}
                                </p>
                                <div class="table-responsive order-table">

                                </div>

                            </div>
                            <div class="col-sm-2">

                                <h4 class="header-title ">Carteira</h4>
                                <h4>
                                    @can('fleet-wallet')
                                    {{ currency($amount) }}
                                    @else
                                    R$ ****
                                    @endcan
                                </h4>

                            </div>
                            <div class="col-sm-2">

                                <p class="header-title ">Disponivel: <b>@can('fleet-wallet-disponible'){{ currency($amountDisponible) }}@else R$ **** @endcan</b></p>
                                @can('fleet-wallet-withdraw')
                                <a class="btn btn-info @if($amountDisponible <  setting('minimum_withdraw_fleet', 1)) disabled @endif" data-toggle="modal" data-amount="{{ currency($amountDisponible) }}" data-target=".bs-modal-withdraw" href="#"> <i class="far fa-edit"></i> SOLICITAR SAQUE</a>
                                @endcan
                            </div>
                        </div>

                    </div>
                </div>
            </div>




            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <ul class="nav nav-tabs" role="tablist">
                            @can('service-types-list')
                            <li class="nav-item ">
                                <a class="nav-link active" data-toggle="tab" href="#services" role="tab">Serviços</a>
                            </li>
                            @endcan

                            @can('peak-hour-list')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#rushhour" role="tab">Horário de Pico</a>
                            </li>
                            @endcan

                            @can('promocodes-list')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#cupons" role="tab">Cupons</a>
                            </li>
                            @endcan

                            @can('fleet-doc-list')                           
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#docs" role="tab">Documentos Extras</a>
                            </li>
                            @endcan

                            @can('fleet-wallet-withdraw-history')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#history" role="tab">Histórico de Saques</a>
                            </li>
                            @endcan
                        </ul>

                        
                        <div class="tab-content">

                            @can('service-types-list')
                            <div class="tab-pane active p-3" id="services" role="tabpanel">
                                @can('service-types-create')
                                <div class="col-sm-12">
                                    <div class="col-xs-12 d-flex justify-content-end">

                                        <a href="{{ route('admin.service.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Adicionar Novo Serviço</a>

                                    </div>
                                </div>
                                <br>
                                @endcan
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>

                                                <th>Imagem</th>
                                                <th>Nome do Serviço</th>
                                                <th>Capacidade</th>
                                                <th>Tarifa Mínima</th>
                                                <th>Preço Base</th>
                                                <th>Distância Base</th>
                                                <th>Preço Distância Base</th>
                                                <th>Preço Minuto</th>
                                                <th>Preço Hora</th>
                                                <th>Lógica de Preços</th>
                                                <th>Imagem de Marcação</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fleet->services as $index => $service)
                                            <tr>
                                                <td>
                                                    @if($service->image)
                                                    <img src="{{$service->image}}" style="height: 50px" >
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->capacity }}</td>
                                                <td>{{ currency($service->min_price) }}</td>
                                                <td>{{ currency($service->fixed) }}</td>
                                                <td>{{ distance($service->distance) }}</td>
                                                <td>{{ currency($service->price) }}</td>
                                                <td>{{ currency($service->minute) }}</td>
                                                @if($service->calculator == 'DISTANCEHOUR' || $service->calculator == 'HOUR')
                                                <td>{{ currency($service->hour) }}</td>
                                                @else
                                                <td>Não</td>
                                                @endif
                                                <td>@lang('servicetypes.'.$service->calculator)</td>

                                                <td>
                                                    @if($service->marker)
                                                    <img src="{{$service->marker}}" style="height: 50px" >
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td width="175">
                                                        @can('service-types-edit')
                                                        <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-info">
                                                            <i class="fa fa-pencil"></i> Editar
                                                        </a>
                                                        @endcan
                                                        @can('service-types-delete')
                                                        <button href="{{ route('admin.service.destroy', $service->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$service->name}}"  class="btn btn-danger" data-title="Deseja realmente excluir esse serviço?">
                                                            <i class="fa fa-trash"></i> Excluir
                                                        </button>
                                                        @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endcan
                            @can('peak-hour-list')
                            <div class="tab-pane p-3" id="rushhour" role="tabpanel">
                                @can('peak-hour-create')

                                <form class="form-horizontal" action="{{route('admin.peakhour.store')}}" method="POST" enctype="multipart/form-data" role="form">
                                        {{csrf_field()}}

                                        <input type="hidden" name="fleet_id" value="{{ $fleet->id }}">                   

                                        <div class="form-group row">
                                            <label for="start_time" class="col-sm-1 col-form-label">@lang('admin.peakhour.start_time')</label>
                                            <div class="col-sm-4">
                                                <input class="form-control start_time" autocomplete="off"  type="text" value="{{ old('start_time') }}" name="start_time"  placeholder="@lang('admin.peakhour.start_time')" required>
                                            </div>

                                            <label for="end_time" class="col-sm-1 col-form-label">@lang('admin.peakhour.end_time')</label>
                                            <div class="col-sm-4">
                                                <input class="form-control end_time" autocomplete="off"  type="text" value="{{ old('end_time') }}" name="end_time" placeholder="@lang('admin.peakhour.end_time')" required>
                                            </div>
                                             <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary">@lang('admin.peakhour.add_time')</button>
                                        </div>

                                        

                                    </div>
                                </form>

                                <br>
                                @endcan
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.peakhour.start_time') </th>
                                                <th>@lang('admin.peakhour.end_time') </th>                           
                                                <th  colspan="2">@lang('admin.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($peakhour as $index => $peak)
                                            
                                            <tr>
                                                <form class="form-horizontal" action="{{route('admin.peakhour.update', $peak->id )}}" method="POST" enctype="multipart/form-data" role="form">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="PATCH">  
                                                <td>
                                                    <input class="form-control start_time" autocomplete="off"  type="text" value="{{ date('h:i A', strtotime($peak->start_time)) }}" name="start_time" required  placeholder="@lang('admin.peakhour.start_time')" required>
                                                </td>
                                                <td>
                                                    <input class="form-control end_time" autocomplete="off"  type="text" value="{{ date('h:i A', strtotime($peak->end_time)) }}" name="end_time" required  placeholder="@lang('admin.peakhour.end_time')" required>
                                                </td>

                                                <td width="90">
                                                    @can('peak-hour-edit')
                                                    <button type="submit" class="btn btn-info  btn-block"><i class="fa fa-pencil"></i> Atualizar</button>
                                                    @endcan
                                                </td>

                                                </form>

                                                <td width="90">
                                                        
                                                        @can('peak-hour-delete')
                                                        <button href="{{ route('admin.peakhour.destroy', $peak->id) }}"  class="btn btn-danger  waves-effect waves-light  btn-block" data-method="delete" data-long-text="{{$peak->start_time}} - {{$peak->end_time}}"  class="btn btn-danger" data-title="Deseja realmente excluir horário?"><i class="fa fa-trash"></i> Excluir</button>
                                                        @endcan
                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endcan

                            @can('promocodes-list')

                            <div class="tab-pane p-3" id="cupons" role="tabpanel">
                                @can('promocodes-create')
                                <div class="col-sm-12">
                                    <div class="col-xs-12 d-flex justify-content-end">

                                        <a href="{{ route('admin.promocode.create') }}?fleet={{ $fleet->id }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.promocode.add_promocode')</a>
                                    </div>
                                </div>
                                <br>
                                @endcan

                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.promocode.promocode') </th>
                                                <th>@lang('admin.promocode.percentage') </th>
                                                <th>@lang('admin.promocode.max_amount') </th>
                                                <th>@lang('admin.promocode.expiration')</th>
                                                <th>@lang('admin.status')</th>
                                                <th>@lang('admin.promocode.used_count')</th>
                                                <th>@lang('admin.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($promocodes as $index => $promo)
                                            <tr>
                                                <td>{{$promo->promo_code}}</td>
                                                <td>{{$promo->percentage}}</td>
                                                <td>{{$promo->max_amount}}</td>
                                                <td>
                                                    {{ date('d/m/Y H:i:s' , strtotime($promo->expiration)) }}

                                                </td>
                                                <td>
                                                    @if(date("Y-m-d H:i") <= $promo->expiration)
                                                    <span class="tag tag-success">Válido</span>
                                                    @else
                                                    <span class="tag tag-danger">Expirado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{promo_used_count($promo->id)}}
                                                </td>
                                                <td>
                                                        @can('promocodes-edit')
                                                        <a href="{{ route('admin.promocode.edit', $promo->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Editar</a>
                                                        @endcan
                                                        @can('promocodes-delete')
                                                        <button href="{{ route('admin.promocode.destroy', $promo->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$promo->promo_code}}"  class="btn btn-danger" data-title="Deseja realmente excluir esse cupom?"><i class="fa fa-trash"></i> Excluir</button>
                                                        @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                            @endcan

                            @can('fleet-doc-list')
                            <div class="tab-pane p-3" id="docs" role="tabpanel">
                                <div class="col-sm-12">
                                    @can('fleet-doc-create')

                                        <form class="form-horizontal" action="{{route('admin.document.store')}}" method="POST" enctype="multipart/form-data" role="form">
                                            {{csrf_field()}}

                                            <input  type="hidden" value="{{ $fleet->id }}" name="fleet_id" />

                                            <div class="card-body">

                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-1 col-form-label">@lang('admin.document.document_name')</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Nome do @lang('admin.document.document_name')">
                                                    </div>

                                                    <label for="name" class="col-sm-2 col-form-label">@lang('admin.document.document_type')</label>
                                                    <div class="col-sm-3">
                                                        <select name="type" class="form-control">
                                                            <option value="DRIVER">@lang('admin.document.driver_review')</option>
                                                            <option value="VEHICLE">@lang('admin.document.vehicle_review')</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-primary">@lang('admin.document.add_Document')</button>
                                                    </div>
                                                </div>

                                            </div>
                                            </form>
                                    @endcan
                                </div>
                                <br>
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.document.document_name')</th>
                                                <th>@lang('admin.type')</th>
                                                <th colspan="2">@lang('admin.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($documents as $index => $document)
                                            <tr>
                                                <form class="form-horizontal" action="{{route('admin.document.update', $document->id )}}" method="POST" enctype="multipart/form-data" role="form">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="PATCH">
                                                <td>
                                                    <input class="form-control" type="text" value="{{ $document->name }}" name="name" required id="name" placeholder="Nome do @lang('admin.document.document_name')">
                                                </td>
                                                <td>
                                                    <select name="type" class="form-control">
                                                        <option value="DRIVER" @if($document->type == 'DRIVER') selected @endif>@lang('admin.document.driver_review')</option>
                                                        <option value="VEHICLE" @if($document->type == 'VEHICLE') selected @endif>@lang('admin.document.vehicle_review')</option>
                                                    </select>
                                                </td>
                                                <td width="70">
                                                    @can('fleet-doc-edit')
                                                    <button type="submit" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.update')</button>
                                                    @endcan
                                                </td>
                                                </form>
                                                <td width="100">
                                                        @can('fleet-doc-delete')
                                                        <button href="{{ route('admin.document.destroy', $document->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$document->name}}"  class="btn btn-danger" data-title="Deseja realmente excluir esse requisito de documento?"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endcan

                            @can('fleet-wallet-withdraw-history')
                            <div class="tab-pane p-3" id="history" role="tabpanel">
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Data</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Obs</th>
                                                <th scope="col" width="200">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($wallterRequests as $wallterRequest)
                                            <tr>
                                                <td>
                                                    <div>
                                                        @if($wallterRequest->request_from == 'provider')
                                                        <img src="{{ img($wallterRequest->provider->picture) }}" alt="" class="thumb-md rounded-circle mr-2"> {{ $wallterRequest->provider->first_name }}  {{ $wallterRequest->provider->last_name }}
                                                        @else
                                                        <img src="{{ img($wallterRequest->fleet->logo) }}" alt="" class="thumb-md rounded-circle mr-2"> {{ $wallterRequest->fleet->name }} 
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $wallterRequest->created_at->diffForHumans() }}
                                                    <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($wallterRequest->created_at)) }}</p>
                                                </td>
                                                <td>{{ currency( $wallterRequest->amount) }}</td>

                                                <td>
                                                    @if($wallterRequest->status == 1)
                                                    <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> Concluido</span>
                                                    @else 
                                                    @if($wallterRequest->status == 0)
                                                    <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Aguardando</span>
                                                    @else
                                                    <span class="badge badge-danger badge-pill"><i class="mdi mdi-checkbox-blank-circle text-danger"></i> Recusado</span>
                                                    @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('fleet-wallet-withdraw-attachment')
                                                    @if($wallterRequest->status == 1 && isset($wallterRequest->picture))
                                                        <span class="badge badge-dark"><a href="{{ img($wallterRequest->picture) }}" target="_blank"><i class="fas fa-paperclip"></i> Ver Anexo</a></span>
                                                    @else
                                                        {{ $wallterRequest->obs }}
                                                    @endif
                                                    @endcan
                                                </td>
                                                <td>
                                                    @if(!$wallterRequest->status == 1 || !$wallterRequest->status == 2 )
                                                    <div class="button-items">
                                                        @can('fleet-wallet-withdraw-send')
                                                        <button type="button" class="btn btn-primary waves-effect waves-light approve" data-toggle="modal" data-target=".bs-modal-confirm" data-href="{{route('admin.approve.confirm', $wallterRequest->id) }}" data-rid="{{$wallterRequest->id}}">@lang('admin.approve')</button>
                                                        @endcan

                                                        @can('fleet-wallet-withdraw-recuse')
                                                        <button type="button" class="btn btn-danger waves-effect waves-light recuse" data-toggle="modal" data-target=".bs-modal-recuse" data-id="cancel" data-href="{{ route('admin.cancel') }}?id={{$wallterRequest->id}}" data-rid="{{$wallterRequest->id}}">Recusar</button>
                                                        @endcan
                                                        @can('fleet-wallet-withdraw-cancel')
                                                        <a class="btn btn-danger waves-effect waves-light transferClass" href="{{ route('admin.fleet.request.amount.cancel') }}?id={{$wallterRequest->id}}">Cancelar Saque</a>
                                                        @endcan
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endcan
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Recuse -->
<div class="modal fade bs-modal-withdraw" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        
            <div class="modal-content">
                <form action="{{route('admin.fleet.request.amount')}}" method="POST">
                {{ csrf_field() }}

                <input type="hidden" name='type' value='fleet'/>
                <input type="hidden" name='fleet_id' value='{{ $fleet->id }}'/>
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Solicitar Saque</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h5>Disponível: <b>{{ currency($amountDisponible) }}</b></h5>
                    <p>O valor disponível é o total repassado que ja foram pagos por motoristas.</p>

                    <input class="form-control" type="text" name="amount" value="{{ $amountDisponible }}" placeholder="Valor">
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Solicitar Saque</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                   </form>
            </div><!-- /.modal-content -->
     

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- SE FOR ADMIN -->


  <div class="modal fade bs-modal-confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="" method="post" enctype="multipart/form-data" id="form-approve">
                    {{csrf_field()}}
                    <div class="modal-header">
                        <h5 class="modal-title mt-0">Confirmar Pagamento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <p>Obs: Ao confirmar o pagamento você declara ter feito o repasse para motorista ou franquia e será realizado um debito na conta administrativa.</p>

                        <div class="form-group">
                            <label>Anexar Comprovante (Se houver)</label>
                            <input type="file" class="filestyle" name="picture" data-buttonname="btn-secondary">
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<!-- Modal Recuse -->
<div class="modal fade bs-modal-recuse" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        
            <div class="modal-content">
                <form action="" method="get" id="form-cancel">
                <input type="hidden" value="" name="id" id="transfer_id">
       
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Recusar Pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Se necessário justifique o motivo da recusa.</p>

                    <input class="form-control" type="text" name="obs" placeholder="Observação">
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Recusar Pagamento</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                   </form>
            </div><!-- /.modal-content -->
     

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection
@section('scripts')

<script src="{{ url('agroxa/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>

<script src="{{ url('asset/js/sweetalert2/sweetalert2.js') }}"></script>
<script type="text/javascript" src="{{asset('asset/js/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript">

    $(".recuse").click(function () {
        $('#form-cancel').attr('action', $(this).attr('data-href'));
        $("#transfer_id").val($(this).attr('data-rid'));

    });
    
    $(".approve").click(function () {
        $('#form-approve').attr('action', $(this).attr('data-href'));
        //$("#transfer_id").val($(this).attr('data-rid'));

    });

</script>
<script type="text/javascript">
    $(document).ready(function()
    {    
        $('.start_time').bootstrapMaterialDatePicker({  
            format: 'hh:mm A' ,
            date: false,
        });
        $('.end_time').bootstrapMaterialDatePicker({  
            format: 'hh:mm A' ,
            date: false,
        });

    });  
</script>
@endsection



