@extends('admin.layout.app')

@section('title', 'Detalhes do Motorista ')

@section('styles')

<link href="{{ url('asset/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ url('agroxa/plugins/morris/morris.css') }}">
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
                                <h6 style="margin-bottom: 0px">Dados do motorista</h6>
                            </div>

                            <div class="col-sm-6 d-flex justify-content-end button-items">
                                @can('provider-edit')
                                <a class="btn btn-primary " href="{{ route('admin.provider.edit', $provider->id) }}"> <i class="far fa-edit"></i> @lang('admin.edit')</a>
                                @endcan
                                @can('provider-delete')
                                <button href="{{ route('admin.provider.destroy', $provider->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$provider->first_name}} {{$provider->last_name}} - {{ $provider->email }}"  class="btn btn-danger" data-title="Deseja realmente excluir esse motorista?"><i class="far fa-trash-alt"></i> @lang('admin.delete')</button>
                                @endcan

                                @can('provider-active')
                                @if($provider->status == 'approved')
                                <a  class="btn btn-danger pull-right" href="{{ route('admin.provider.disapprove', $provider->id ) }}"><i class="fa fa-power-off"></i> Desativar Motorista</a>
                                @else
                                <a  class="btn btn-success pull-right" href="{{ route('admin.provider.approve', $provider->id ) }}"><i class="fa fa-check"></i> Aprovar Motorista</a>
                                @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 border-right">
                                <div>
                                    <div class="directory-img float-left mr-4">
                                        <img src="{{img($provider->avatar)}}" alt="" class="thumb-md rounded-circle mr-2">
                                    </div>
                                    <p class="text-muted mb-2">
                                        {{$provider->getFullNameAttribute() }}
                                        <br>
                                        {{$provider->email}} | {{$provider->mobile}}
                                        <br>
                                        <span class="mdi mdi-star @if($provider->rating >=1) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($provider->rating >=2) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($provider->rating >=3) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($provider->rating >=4) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($provider->rating >=5) text-warning @endif"></span>
                                    </p>


                                </div>
                            </div>
                            <div class="col-xl-3 border-right">
                                <p class="text-muted mb-2">
                                    {{ $provider->city->title }} -  {{ $provider->city->state->letter }}
                                    <br>
                                    CPF: {{ $provider->cpf }}
                                </p>
                                <div class="table-responsive order-table">
                                    @can('provider-status')
                                    @if($provider->active_documents() == $total_documents && $provider->service != null)
                                    <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> VERIFICADO</span>

                                    @else
                                    <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> PENDENTE</span>
                                    @endif
                                    @endcan

                                    @if($provider->service)
                                    @if($provider->service->status == 'active')
                                    <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i>ATIVO</span>
                                    @else
                                    <span class="badge badge-danger badge-pill"><i class="mdi mdi-checkbox-blank-circle text-danger"></i>INATIVO</span>
                                    @endif
                                    @else
                                    <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i>N/A</span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-xl-5">
                                <div class="row">
                                    <div class="col-xl-5 border-right">
                                        <h4 class="header-title">Carteira</h4>
                                        <h4>
                                            @can('provider-wallet')
                                            {{ currency($amount) }}
                                            @else
                                            R$ ****
                                            @endcan
                                        </h4>
                                    </div>
                                    <div class="col-xl-4" style="padding-top: 6px">
                                        <svg height="16" width="16"><circle cx="10" cy="10" r="6" fill="#5fc768"/></svg>  <span class="ml-2">Concluido</span>
                                        <br>
                                        <svg height="16" width="16"><circle cx="10" cy="10" r="6" fill="#fa7d7d"/></svg> <span class="ml-2">Cancelado</span>
                                    </div>
                                    <div class="col-xl-3" style="padding-top: 6px">

                                        <span class="peity-donut" data-peity='{ "fill": ["#5fc768", "#fa7d7d"], "innerRadius": 20, "radius": 32 }' data-width="54" data-height="54">{{$canceled}},{{$approved}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-sm-12">
                <div class="card m-b-20">

                    <div class="card-body">

                        <ul class="nav nav-tabs" role="tablist">
                            @can('provider-services')
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-services" role="tab">Serviços</a>
                            </li>
                            @endcan
                            @can('provider-documents')
                            <li class="nav-item">

                                <a class="nav-link" data-toggle="tab" href="#tab-documents" role="tab">
                                    Documentos 
                                    @if( $provider->active_documents() != $total_documents)
                                    <span class="badge badge-pill badge-danger">{{ $total_documents -  $provider->active_documents() }}</span>
                                    @else
                                    <span class="badge badge-pill badge-primary">{{ count($provider->documents) }}</span>
                                    @endif
                                </a>
                            </li>
                            @endcan
                            @can('provider-wallet-withdrawals')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-history" role="tab">Histórico de Saques</a>
                            </li>
                            @endcan
                            @can('provider-reviews')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-reviews" role="tab">Avaliações</a>
                            </li>
                            @endcan

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="tab-services" role="tabpanel">

                                @can('provider-services')
                                <div class="row">
                                    @if($providerService->count() > 0)
                                    <div class="col-sm-12">
                                        <h5>Serviços Atribuídos </h5>
                                        <div class="table-responsive order-table">
                                            <table class="table table-hover mb-0">
                                                <tr>
                                                    <th>@lang('admin.provides.service_name')</th>
                                                    <th>@lang('admin.provides.service_number')</th>
                                                    <th>@lang('admin.provides.service_model')</th>
                                                    @can('provider-service-delete')
                                                    <th>@lang('admin.action')</th>
                                                    @endcan
                                                </tr>
                                                @foreach($providerService as $service)
                                                <tr>
                                                    <td>{{ $service->service_type->name }} - {{ $service->service_type->fleet->name }}</td>
                                                    <td>{{ $service->service_number }}</td>
                                                    <td>{{ $service->service_model }}</td>
                                                    @can('provider-service-delete')
                                                    <td>
                                                        <button href="{{ route('admin.provider.document.service',[$provider->id, $service->id]) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{ $service->service_type->name }} - {{ $service->service_type->fleet->name }}"  class="btn btn-danger" data-title="Deseja realmente excluir esse serviço?"><i class="far fa-trash-alt"></i> @lang('admin.delete')</button>
                                                    </td>
                                                    @endcan
                                                </tr>
                                                @endforeach

                                            </table>
                                        </div>
                                        <hr>
                                    </div>
                                    @endif

                                    @can('provider-service-update')
                                    @if($providerService->count() >= 1)
                                    <div class="col-sm-12">
                                        <h5>Atualizar Serviço</h5>

                                        <form class="form-horizontal" action="{{ route('admin.provider.document.store', $provider->id) }}" method="POST">
                                            {{ csrf_field() }}

                                            <div class="form-group row">
                                                <input type="hidden" required name="method" value="update">
                                                <div class="col-sm-5">
                                                    <select class="form-control input" name="service_type" required>
                                                        @forelse($serviceTypes as $Type)
                                                        <option value="{{ $Type->id }}">{{ $Type->fleet->name }} - {{ $Type->name }}</option>
                                                        @empty
                                                        <option>- @lang('admin.service_select') -</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" required name="service_number" class="form-control" placeholder="Número/Placa (jss-0000)">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" required name="service_model" class="form-control" placeholder="Modelo (Siena Sedan - Branco)">
                                                </div>
                                                <div class="col-sm-1">
                                                    @can('provider-service-update')<button class="btn btn-success btn-block" type="submit">Atualizar</button>@endcan
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                    @endcan

                                    @can('provider-service-add')
                                    @if($providerService->count() == 0)
                                    <div class="col-sm-12">
                                        <h5>Adicionar Serviço</h5>

                                        <form class="form-horizontal"  action="{{ route('admin.provider.document.store', $provider->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <input type="hidden" required name="method" value="create">
                                                <div class="col-sm-4">
                                                    <select class="form-control input" name="service_type" required>
                                                        @forelse($serviceTypes as $Type)
                                                        <option value="{{ $Type->id }}">{{ $Type->fleet->name }} - {{ $Type->name }}</option>
                                                        @empty
                                                        <option>- @lang('admin.service_select') -</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" required name="service_number" class="form-control" placeholder="Número/Placa (jss-0000)">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" required name="service_model" class="form-control" placeholder="Modelo (Siena Sedan - Branco)">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-primary btn-block" type="submit">Adicionar</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                    @endcan

                                </div>
                                @endcan
                            </div>

                            @can('provider-documents')
                            <div class="tab-pane p-3" id="tab-documents" role="tabpanel">

                                <div class="box box-block bg-white">
                                    <h5 class="mb-1">
                                        @lang('admin.provides.provider_documents')<br>

                                    </h5>
                                     @if( $provider->active_documents() != $total_documents)
                                    <br>
                                    <form action="{{ route('admin.provider.document.add') }}" method="POST" enctype="multipart/form-data">
                                         {{csrf_field()}}
                                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                                        <div class="row">
                                            <div class="form-group col-xl-4">
                                                <label>Tipo de Documento (Obrigatório)</label>
                                                <select class="form-control input" name="document_id" required>
                                                    @forelse($documents_required as $document_required)
                                                    @if($document_required->providerdocuments == null)
                                                    <option value="{{ $document_required->id }}">{{ $document_required->name }} - {{ $document_required->type == 'DRIVER' ? "MOTORISTA" : "VEÍCULO" }}</option>
                                                    @endif
                                                    @empty
                                                    <option>- Nenhum tipo de documento cadastrado -</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-5">
                                                <label>Anexar Documento (Obrigatório)</label>
                                                <input type="file" class="filestyle" name="document" required="" data-buttonname="btn-secondary">
                                            </div>
                                            <div class="form-group col-xl-3" style="margin-top: 28px">
                                                 <button type="submit" class="btn btn-primary">Adicionar</button>
                                            </div>

                                        </div>
                                    </form>
                                    @endif

                                    <div class="table-responsive order-table">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>@lang('admin.provides.document_type')</th>
                                                    <th>Data de Envio</th>
                                                    <th>@lang('admin.status')</th>
                                                    <th width="340">@lang('admin.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($provider->documents as $Document)
                                                <tr>
                                                    <td>@if($Document->document){{ $Document->document->name }}@endif</td>
                                                    <td>
                                                        {{ $Document->created_at->diffForHumans() }}
                                                        <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($Document->created_at)) }}</p>
                                                    </td>
                                                    <td>
                                                        @if($Document->status == "ACTIVE")
                                                        <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> {{ "APROVADO" }}</span></td>

                                                        @else 

                                                        <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> {{ "AVALIAÇÃO PENDENTE" }} </span></td>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-group-btn">
                                                            @can('provider-document-edit')

                                                            <a href="{{ route('admin.provider.document.path') }}?path={!! base64_encode($Document->url) !!}"  ><span class="btn btn-success btn-large"><i class="fas fa-cloud-download-alt"></i> Baixar</span></a>
                                                            @if($Document->status != "ACTIVE")
                                                            <a href="#" class="show-document" data-href="{{ route('admin.provider.document.update', [$provider->id, $Document->id]) }}" data-toggle="modal" data-target=".bs-modal-document" data-doc-name="{{ $Document->document->name }}" ><span class="btn btn-primary btn-large">Aprovar</span></a>
                                                            @endif
                                                            @endcan
                                                            @can('provider-document-delete')
                                                            <button href="{{ route('admin.provider.document.destroy', [$Document->provider->id, $Document->id]) }}"  class="btn btn-danger waves-effect waves-light" data-method="delete" data-long-text="{{ $Document->document->name }}"  class="btn btn-danger" data-title="Deseja realmente recusar e excluir esse documento?"><i class="far fa-trash-alt"></i> Recusar e Excluir</button>

                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            @can('provider-wallet-withdrawals')

                            <div class="tab-pane p-3" id="tab-history" role="tabpanel">
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Data</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Obs</th>
                                                <th scope="col">Status</th>
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
                                                    {{ $wallterRequest->obs }}
                                                </td>
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
                                                    @if(!$wallterRequest->status == 1 || !$wallterRequest->status == 2 )
                                                    <div class="button-items">
                                                        @can('provider-wallet-withdraw-approve')
                                                        <button type="button" class="btn btn-primary waves-effect waves-light approve" data-toggle="modal" data-target=".bs-modal-confirm" data-href="{{route('admin.approve.confirm', $wallterRequest->id) }}" data-rid="{{$wallterRequest->id}}">@lang('admin.approve')</button>
                                                        @endcan

                                                        @can('provider-wallet-withdraw-recuse')
                                                        <button type="button" class="btn btn-danger waves-effect waves-light recuse" data-toggle="modal" data-target=".bs-modal-recuse" data-id="cancel" data-href="{{ route('admin.cancel') }}?id={{$wallterRequest->id}}" data-rid="{{$wallterRequest->id}}">Recusar</button>
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

                            @can('provider-reviews')
                            <div class="tab-pane p-3" id="tab-reviews" role="tabpanel">
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.request.User_Name')</th>
                                                <th>@lang('admin.review.Rating')</th>
                                                <th>@lang('admin.request.Date_Time')</th>
                                                <th>Comentário do Solicitante</th>
                                                <th>Comentário do Motorista</th>
                                                <th>@lang('admin.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($page = ($pagination->currentPage-1)*$pagination->perPage)    
                                            @foreach($reviews as $index => $review)

                                            <tr>
                                                <td>{{$review->user?$review->user->first_name:''}} {{$review->user?$review->user->last_name:''}}</td>
                                                <td>
                                                    <span class="mdi mdi-star @if($review->provider_rating >=1) text-warning @endif"></span>
                                                    <span class="mdi mdi-star @if($review->provider_rating >=2) text-warning @endif"></span>
                                                    <span class="mdi mdi-star @if($review->provider_rating >=3) text-warning @endif"></span>
                                                    <span class="mdi mdi-star @if($review->provider_rating >=4) text-warning @endif"></span>
                                                    <span class="mdi mdi-star @if($review->provider_rating >=5) text-warning @endif"></span>

                                                </td>
                                                <td>
                                                    {{ $review->created_at->diffForHumans() }}
                                                    <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($review->created_at)) }}</p>
                                                </td>
                                                <td>{{$review->user_comment}}</td>
                                                <td>{{$review->provider_comment}}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.requests.show', $review->request_id) }}" class="btn btn-primary waves-effect">
                                                            Detalhes do serviço
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                @include('common.pagination')
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            @can('provider-history')
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <div class="row" style="margin-left: 6px">
                            <div class="col s3">
                                <p><b>TOTAL</b></p>
                                <p style="color: #039be5"><b>R$ {!! number_format($releaseTotal, 2, ",", "." ) !!}</b></p>
                            </div>            
                            <div class="col s3">
                                <p><b>RECEITAS</b></p>
                                <p  style="color: #2e7d32"><b>R$  {!! number_format( $releaseRecipe, 2, ",", "." ) !!}</b></p>
                            </div>            
                            <div class="col s3">
                                <p><b>CANCELADO (Estimativa)</b></p>
                                <p  style="color: #d84315"><b>R${!! number_format( $releasesCanceled, 2, ",", "." ) !!}</b></p>
                            </div>
                            <div class="col s3">
                                <p><b>COMISSÕES</b></p>
                                <p style="color: #ff9800"><b>R$ {!! number_format( $releaseComission, 2, ",", "." ) !!}</b></p>
                            </div>
                        </div>

                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Valor Total</th>
                                        @if($typeList != 'admin')
                                        <th scope="col">Comissão Adm</th>
                                        @endif
                                        <th scope="col">Comissão Franquia</th>
                                        <th scope="col">Forma de Pagamento</th>
                                        <th scope="col">OS</th>
                                        <th scope="col">Status</th>
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

                                            <td>#</td>
                                            <td>#</td>
                                            <td>#</td>
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
                                                @if($typeList != 'admin')
                                                <td>
                                                    {{ currency( $release->payment->commision) }}
                                                </td>
                                                @endif                                              
                                                <td>
                                                    {{ currency( $release->payment->fleet) }}
                                                </td>

                                                @else
                                                <td>
                                                    {{ currency($release->estimated_fare) }}
                                                </td>
                                                @if($typeList != 'admin')
                                                <td>
                                                    {{ currency( $release->payment->commision) }}
                                                </td>
                                                @endif
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
                                                    <div class="icon-demo-content" style="text-align: left;">
                                                        @if($release->device_type == 'android' )
                                                            <i class="mdi mdi-android" style="color: green"></i>
                                                        @elseif($release->device_type == 'ios' )
                                                            <i class="mdi mdi-apple"></i>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
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
                            </div>
                        </div>
                    </div>
                    @endcan



                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bs-modal-document" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">

                <form action="#" method="POST" enctype="multipart/form-data" id="form-document">
                    {{csrf_field()}}
                    {{ method_field('PATCH') }}
                    <div class="modal-header">
                        <h5 class="modal-title mt-0">Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <h4>Documento: <span id="doc-name"></span></h4>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Confirmar Aprovar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


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

    <script src="{{ url('agroxa/plugins/peity/jquery.peity.min.js') }}"></script>

    <script type="text/javascript">
        $(".show-document").click(function () {
            $('#form-document').attr('action', $(this).attr('data-href'));
            $('#doc-name').html($(this).attr('data-doc-name'));
        });

        $(".recuse").click(function () {
            $('#form-cancel').attr('action', $(this).attr('data-href'));
            $("#transfer_id").val($(this).attr('data-rid'));

        });

        $(".approve").click(function () {
            $('#form-approve').attr('action', $(this).attr('data-href'));
//$("#transfer_id").val($(this).attr('data-rid'));

});

        $('.peity-donut').each(function () {
            $(this).peity("donut", $(this).data());
        });
    </script>
    @endsection
