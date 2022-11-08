@extends('admin.layout.app')


@section('title', 'Painel')
@section('subtitle', 'Bem vindo ao Painel de Controle')

@section('content')
<!-- 
<div class="page-title-box">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="state-information d-none d-sm-block">
                    <div class="state-graph">
                        <div id="header-chart-1"></div>
                        <div class="info">Balance $ 2,317</div>
                    </div>
                    <div class="state-graph">
                        <div id="header-chart-2"></div>
                        <div class="info">Item Sold 1230</div>
                    </div>
                </div>
                

                <h4 class="page-title">Painel</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Bem vindo ao Painel de Controle</li>
                </ol>

            </div>
        </div>
    </div>

</div>
-->



<div class="page-content-wrapper">
    <div class="container-fluid">

        @can('dashboard-cards')
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <h6 class="text-uppercase verti-label text-white-50">TOTAL .VIA</h6>
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">@lang('admin.dashboard.Rides')</h6>
                                <h3 class="mb-3 mt-0">
                                    @if (!is_null($totalRides))
                                    {{$totalRides}}
                                    @endif
                                </h3>
                                <div class="">
                                    <span class="badge badge-light text-info"> {{$totalRides}} </span> <span class="ml-2">Realizadas em todo período</span>
                                </div>
                            </div>
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-cube-outline display-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <h6 class="text-uppercase verti-label text-white-50">@lang('admin.dashboard.Revenue')</h6>
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">@lang('admin.dashboard.Revenue')</h6>
                                <h3 class="mb-3 mt-0">{{currency($revenue)}}</h3>
                                <div class="">
                                    <span class="badge badge-light text-danger"> {{currency($revenue)}} </span> <span class="ml-2">Recebido em todo período</span>
                                </div>
                            </div>
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-buffer display-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">

                            @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                            <h6 class="text-uppercase verti-label text-white-50">Passag.</h6>
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">@lang('admin.dashboard.passengers')</h6>
                                <h3 class="mb-3 mt-0">{{$users}}</h3>
                                <div class="">
                                    <span class="badge badge-light text-primary"> {{$users}} </span> <span class="ml-2">Cadastrados no sistema</span>
                                </div>
                            </div>
                            @else
                            <h6 class="text-uppercase verti-label text-white-50">VIAG. CANC</h6>
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">VIAGENS CANCELADAS</h6>
                                <h3 class="mb-3 mt-0">{{$user_cancelled}}</h3>
                                <div class="">
                                    <span class="badge badge-light text-primary"> {{$user_cancelled}} </span> <span class="ml-2">Viagens Canceladas</span>
                                </div>
                            </div>
                            @endif

                            <div class="mini-stat-icon">
                                <i class="mdi mdi-tag-text-outline display-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <h6 class="text-uppercase verti-label text-white-50">MOTORS.</h6>
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">@lang('admin.dashboard.providers')</h6>
                                <h3 class="mb-3 mt-0">{{$provider}}</h3>
                                <div class="">
                                    <span class="badge badge-light text-info"> {{$provider}} </span> <span class="ml-2">Cadastrados no sistema</span>
                                </div>
                            </div>
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-briefcase-check display-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
   
        @endcan


        @can('dashboard-recent-trip')

        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title mb-4">@lang('admin.dashboard.Recent_Rides')</h4>
                                    <div class="table-responsive order-table">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Data/Horário</th>
                                                    <th scope="col">Valor</th>
                                                    <th scope="col">OS</th>
                                                    <th scope="col" colspan="2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (is_null($rides))
                                                    Nenhuma viagem recente encontrada!
                                                @else
                                                     @foreach($rides as $index => $ride)
                                                      <tr>
                                                        <td>
                                                            <div>
                                                                <img src="{{img($ride->user->picture)}}" alt="" class="thumb-md rounded-circle mr-2"> {{$ride->user->first_name}} {{$ride->user->last_name}}
                                                            </div>
                                                        </td>
                                                        <td>{{$ride->created_at->diffForHumans()}}
                                                            <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($ride->created_at)) }}</p>
                                                        </td>
                                                        <td>R$ @if($ride->payment){{ $ride->payment->fixed }}@else 0,0 @endif</td>
                                                        <td>
                                                            <div class="icon-demo-content" style="text-align: left;">
                                                            @if($ride->device_type == 'android' )
                                                                <i class="mdi mdi-android" style="color: green"></i>
                                                            @elseif($ride->device_type == 'ios' )
                                                                <i class="mdi mdi-apple"></i>
                                                            @else
                                                                N/A
                                                            @endif
                                                            </div>
                                                        </td>
                                                        <td width="250">

                                                            @if($ride->status == "COMPLETED")
                                                                <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> CONCLUÍDA</span>
                                                            @elseif($ride->status == "CANCELLED")
                                                                <span class="badge badge-danger badge-pill"><i class="mdi mdi-checkbox-blank-circle text-danger"></i> CANCELADA</span>

                                                                @if($ride->cancelled_by == 'NONE')
                                                                     <span class="badge badge-info badge-pill"><i class="mdi mdi-checkbox-blank-circle text-info"></i> ADMIN</span>
                                                                @else
                                                                    @if($ride->cancelled_by == 'PROVIDER')
                                                                        <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> MOTORISTA</span>
                                                                    @else
                                                                        @if($ride->cancelled_by == 'USER')
                                                                        <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> PASSAGEIRO</span>
                                                                        @endif
                                                                    @endif
                                                                @endif

                                                                @php
                                                                    $countCanceled = $ride->canceled->count();
                                                                @endphp
                                                                @if($countCanceled  > 0)
                                                                    <span class="badge badge-pill badge-success"> {{ $countCanceled }} </span> 
                                                                @endif
                                                            @elseif($ride->status == "ARRIVED")
                                                                <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> EM ANDAMENTO</span>
                                                            @elseif($ride->status == "SEARCHING")
                                                                <span class="badge badge-info badge-pill"><i class="mdi mdi-checkbox-blank-circle text-info"></i> PESQUISANDO</span>
                                                            @elseif($ride->status == "ACCEPTED")
                                                                <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> MOTORISTA A CAMINHO</span>
                                                            @elseif($ride->status == "STARTED")
                                                                <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> VIAGEM ACEITA</span>
                                                            @elseif($ride->status == "DROPPED")
                                                                 <span class="badge badge-info badge-pill"><i class="mdi mdi-checkbox-blank-circle text-info"></i> NO DESTINO</span>
                                                            @elseif($ride->status == "PICKEDUP")
                                                                 <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> INICIADA</span>
                                                            @elseif($ride->status == "SCHEDULED")
                                                                 <span class="badge badge-dark badge-pill"><i class="mdi mdi-checkbox-blank-circle text-dark"></i> AGENDADA</span>
                                                            @endif

                                                        </td>
                                                        
                                                        <td width="250">
                                                            <div>
                                                                @if($ride->provider_id > 0)
                                                                @can('provider-list')
                                                                <a href="{{ route('admin.provider.show', $ride->provider_id) }}" class="btn btn-success btn-sm">Motorista</a>
                                                                @endcan
                                                                @endif                                                                
                                                                @can('user-details')
                                                                <a href="{{ route('admin.user.show', $ride->user_id) }}" class="btn btn-info btn-sm">Passageiro</a>
                                                                @endcan
                                                                @can('dashboard-recent-trip-details')
                                                                <a href="{{route('admin.requests.show',$ride->id)}}" class="btn btn-primary btn-sm">Detalhes</a>
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    </tr>


                                                     @endforeach
                                                @endif

                                                
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

@endsection