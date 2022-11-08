@extends('admin.layout.app')

@section('title', 'Detalhes do Usuário')

@section('styles')
<link rel="stylesheet" href="{{ url('agroxa/plugins/morris/morris.css') }}">

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
                            <h6 style="margin-bottom: 0px">Dados do Usuário</h6>
                        </div>
                        
                        <div class="col-sm-6 d-flex justify-content-end button-items">
                            @can('user-edit')
                             <a class="btn btn-primary " href="{{ route('admin.user.edit', $user->id) }}"> <i class="far fa-edit"></i> @lang('admin.edit')</a>
                            @endcan

                            @can('user-delete')
                             <button href="{{ route('admin.user.destroy', $user->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$user->first_name}} {{$user->last_name}} - {{ $user->email }}"  class="btn btn-danger" data-title="Deseja realmente excluir esse usuário?"><i class="far fa-trash-alt"></i> @lang('admin.delete')</button>
                             @endcan

                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 border-right">
                                <div>
                                    <div class="directory-img float-left mr-4">
                                        <img src="{{img($user->picture)}}" alt="" class="thumb-md rounded-circle mr-2"> 
                                    </div>
                                    <p class="text-muted mb-2">
                                        {{$user->first_name }} {{$user->last_name }}
                                        <br>
                                        {{$user->email}} | {{$user->mobile}}
                                        <br>
                                        <span class="mdi mdi-star @if($user->rating >=1) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($user->rating >=2) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($user->rating >=3) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($user->rating >=4) text-warning @endif"></span>
                                        <span class="mdi mdi-star @if($user->rating >=5) text-warning @endif"></span>
                                    </p>


                                </div>
                            </div>
                            <div class="col-xl-3 border-right">
                                <p class="text-muted mb-2">
                                    {{ $user->city->title }} -  {{ $user->city->state->letter }}
                                    <br>
                                    CPF: {{ $user->cpf }}
                                </p>
                                <div class="table-responsive order-table">
                                    
                                </div>

                            </div>
                            <div class="col-xl-5">
                                <div class="row">
                                    <div class="col-xl-5 border-right">
                                        <h4 class="header-title">Carteira</h4>
                                        <h4>
                                        @can('user-wallet')
                                        {{ currency($amount) }}
                                        @else
                                         R$ ****
                                        @endif
                                        </h4>
                                    </div>
                                    <div class="col-xl-4" style="padding-top: 6px">
                                        <svg height="16" width="16"><circle cx="10" cy="10" r="6" fill="#5fc768"/></svg>  <span class="ml-2">Concluido</span>
                                        <br>
                                        <svg height="16" width="16"><circle cx="10" cy="10" r="6" fill="#fa7d7d"/></svg> <span class="ml-2">Cancelado</span>
                                    </div>
                                    <div class="col-xl-3" style="padding-top: 6px">

                                        <span class="peity-donut" data-peity='{ "fill": ["#5fc768", "#fa7d7d"], "innerRadius": 20, "radius": 32 }' data-width="54" data-height="54">{{$approved}},{{$canceled}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            @can('user-history')
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
                                                <td>
                                                    {{ currency( $release->payment->commision) }}
                                                </td>
                                                <td>
                                                    {{ currency( $release->payment->fleet) }}
                                                </td>


                                                @else
                                                <td>
                                                    {{ currency($release->estimated_fare) }}
                                                </td>
                                                <td>
                                                    R$0,00
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

    @endsection

    @section('scripts')

    <script src="{{ url('asset/js/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ url('agroxa/plugins/peity/jquery.peity.min.js') }}"></script>

    <script type="text/javascript">
        $('.peity-donut').each(function () {
            $(this).peity("donut", $(this).data());
        });
    </script>
    @endsection
