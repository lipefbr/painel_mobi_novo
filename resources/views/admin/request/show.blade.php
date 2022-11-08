@extends('admin.layout.app')

@section('title', 'Detalhes da Viagem ')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-right font-16">Ordem: <strong> #{{ $request->booking_id }}</strong></h4>
                                    <h3 class="mt-0">
                                        <img src="{{ setting('site_logo', config('constants.site_logo', asset('logo-black.png'))) }}" style="-webkit-filter: drop-shadow(2px 2px 2px #222); filter: drop-shadow(2px 2px 2px #222); " alt="logo" height="24"/>
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6">
                                        <address>
                                            <strong>Solicitante:</strong><br>
                                            <img src="{{img($request->user->picture)}}" style="margin-right: 18px" class="thumb-md rounded-circle mr-2">
                                            {{ $request->user->first_name }}  {{ $request->user->last_name }}
                                            <br>
                                            {{ $request->distance ? $request->distance : '0' }}{{$request->unit}}
                                            <br>
                                            {{ $request->s_address ? $request->s_address : '-' }}
                                        </address>
                                        <dir class="order-table" style="margin-left: 0px; margin-right: 0px; padding-left: 0px; padding-bottom: 8ox">
                                        @if($request->status == "COMPLETED")
                                            <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> CONCLUÍDA</span>
                                        @elseif($request->status == "CANCELLED")
                                            <span class="badge badge-danger badge-pill"><i class="mdi mdi-checkbox-blank-circle text-danger"></i> CANCELADA</span>

                                            @if($request->cancelled_by == 'NONE')
                                                 <span class="badge badge-info badge-pill"><i class="mdi mdi-checkbox-blank-circle text-info"></i> ADMIN</span>
                                            @else
                                                @if($request->cancelled_by == 'PROVIDER')
                                                    <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> MOTORISTA</span>
                                                @else
                                                    @if($request->cancelled_by == 'USER')
                                                    <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> PASSAGEIRO</span>
                                                    @endif
                                                @endif
                                            @endif

                                            @if($request->canceled_at != '' && $request->canceled_at != null)
                                                <span class="badge badge-dark badge-pill" style="background-color: #2fcaca"><i class="mdi mdi-checkbox-blank-circle"  style="color: #4ae3e3"></i>
                                                {{ gmdate("H:i:s", strtotime($request->canceled_at) - strtotime($request->created_at)) }}  ATÉ CANCELAR
                                                </span>
                                            @endif
                                            @if(strlen($request->cancel_reason) > 2)
                                            <blockquote class="blockquote" style="margin-top: 8px">
                                            {{ $request->cancel_reason }}
                                            </blockquote>
                                            @endif
                                        @elseif($request->status == "ARRIVED")
                                            <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> EM ANDAMENTO</span>
                                        @elseif($request->status == "SEARCHING")
                                            <span class="badge badge-info badge-pill"><i class="mdi mdi-checkbox-blank-circle text-info"></i> PESQUISANDO</span>
                                        @elseif($request->status == "ACCEPTED")
                                            <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> MOTORISTA A CAMINHO</span>
                                        @elseif($request->status == "STARTED")
                                            <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> VIAGEM ACEITA</span>
                                        @elseif($request->status == "DROPPED")
                                             <span class="badge badge-info badge-pill"><i class="mdi mdi-checkbox-blank-circle text-info"></i> NO DESTINO</span>
                                        @elseif($request->status == "PICKEDUP")
                                             <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> INICIADA</span>
                                        @elseif($request->status == "SCHEDULED")
                                             <span class="badge badge-dark badge-pill"><i class="mdi mdi-checkbox-blank-circle text-dark"></i> AGENDADA</span>
                                        @endif
                                        </dir>

                                    </div>
                                    <div class="col-6 text-right">
                                        <address>
                                            <strong>Motorista:</strong><br>
                                            @if(is_object($request->provider))
                                            <p>
                                            <a href="{{ route('admin.provider.show', $request->provider->id) }}">
                                            {{ $request->provider->first_name }} {{ $request->provider->last_name }}
                                            @if(is_object($request->provider))
                                             <img src="{{img($request->provider->avatar)}}" style="margin-left: 18px" class="thumb-md rounded-circle mr-2">
                                             @endif
                                             <br>
                                             </a>
                                             </p>
                                             @else
                                              <p>N/A</p>
                                             @endif

                                            {{ $request->d_address ? $request->d_address : '-' }}
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 m-t-30">
                                        <address>
                                            <strong>Metodo de Pagamento:</strong><br>
                                            @if(is_object($request->payment))
                                                @if($request->payment->payment_mode == 'CASH')
                                                DINHEIRO
                                                @elseif($request->payment->payment_mode == 'DEBIT_MACHINE')
                                                DÉBITO MÁQUINA
                                                @elseif($request->payment->payment_mode == 'VOUCHER')
                                                VOUCHER
                                                @else
                                                CARTÃO
                                                @endif
                                            @else
                                                @if($request->payment_mode == 'CASH')
                                                DINHEIRO
                                                @elseif($request->payment_mode == 'DEBIT_MACHINE')
                                                DÉBITO MÁQUINA
                                                @elseif($request->payment_mode == 'VOUCHER')
                                                VOUCHER
                                                @else
                                                CARTÃO
                                                @endif
                                            @endif
                                        </address>

                                         <strong>Serviço: </strong><br>
                                         <p>
                                        @if(strlen($request->service_type->image) > 0)
                                         <img src="{{img($request->service_type->image)}}" style="margin-right: 18px"  class="" height="15">
                                        @endif
                                        {{ strtoupper($request->service_type->name) }}
                                        <br>
                                    </p>
                                    </div>
                                    <div class="col-6 m-t-30 text-right">
                                        <address>
                                            <strong>Data:</strong><br>
                                            @if($request->status == 'SCHEDULED')
                                            @if($request->schedule_at != "")
                                                {{$request->schedule_at->diffForHumans()}}
                                                <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($request->schedule_at)) }}</p>
                                            @else
                                            -
                                            @endif
                                            @else
                                            @if($request->finished_at != "" && $request->finished_at !=  null)
                                            {{$request->finished_at->diffForHumans()}}
                                            <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($request->finished_at)) }}</p>
                                            @else
                                               <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($request->created_at)) }}</p> 
                                            @endif
                                            @endif

                                        </address>
                                    </div>
                                </div>

                                @php
                                    $countCanceled = $request->canceled->count();
                                @endphp
                                @if($countCanceled >  0)
                                     <div class="p-2">
                                        <h3 class="font-16"><strong>Cliques em cancelar sem aceitar a corrida</strong></h3>
                                    </div>
                                    <div class="table-responsive order-table">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>@lang('admin.provides.full_name')</th>
                                                    <th>@lang('admin.mobile')</th>
                                                    <th>Distância do pass.</th>
                                                    <th>Tempo até cancelar</th>
                                                    <th>Tarifa estimada</th>
                                                    <th>@lang('admin.provides.total_requests')</th>
                                                    <th>@lang('admin.provides.accepted_requests')</th>
                                                    <th>@lang('admin.provides.online')</th>
                                                    <th>@lang('admin.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($request->canceled as $canceled)
                                                @php
                                                    $provider = $canceled->provider;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <img src="{{img($provider->avatar)}}" alt="" class="thumb-md rounded-circle mr-2">
                                                        {{ $provider->first_name }} {{ $provider->last_name }}</td>

                                                    <td>{{ $provider->mobile }}</td>
                                                    <td> {{ $canceled->p_distance ? $canceled->p_distance : '0' }}{{$canceled->unit}}</td>
                                                    
                                                    <td>{{ gmdate("H:i:s", strtotime($canceled->created_at) - strtotime($request->created_at)) }}</td>
                                                    <td>{{ currency($request->estimated_fare) }}</td>
                                                    <td>{{ $provider->total_requests() }}</td>
                                                    <td>{{ $provider->accepted_requests() }}</td>
                                                    <td>
                                                        @if($provider->service)
                                                        @if($provider->service->status == 'active')
                                                        <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i>SIM</span>
                                                        @else
                                                        <span class="badge badge-danger badge-pill"><i class="mdi mdi-checkbox-blank-circle text-danger"></i>NÃO</span>
                                                        @endif
                                                        @else
                                                        <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i>N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-group-btn">
                                                            @can('provider-details')
                                                            <a class="btn btn-primary waves-effect waves-light btn-block" href="{{ route('admin.provider.show', $provider->id) }}">Detalhes</a>
                                                            @endcan

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @include('common.pagination')
                                    

                                @endif


                                <div>
                                    <div class="p-2">
                                        <h3 class="font-16"><strong>Resumo</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Descrição</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right"><strong>Total</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if($request->payment)
                                                    <tr>
                                                        <td>@lang('admin.request.base_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->fixed) }}</td>
                                                    </tr>

                                                    @if($request->service_type->calculator=='MIN')
                                                    <tr>
                                                        <td>@lang('admin.request.minutes_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->minute) }}</td>
                                                    </tr>
                                                    @endif

                                                    @if($request->service_type->calculator=='HOUR')
                                                    <tr>
                                                        <td>@lang('admin.request.hours_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->hour) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($request->service_type->calculator=='DISTANCE')
                                                    <tr>
                                                        <td>@lang('admin.request.distance_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->distance) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($request->service_type->calculator=='DISTANCEMIN')
                                                    <tr>
                                                        <td>@lang('admin.request.minutes_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->minute) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('admin.request.distance_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->distance) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($request->service_type->calculator=='DISTANCEHOUR')
                                                    <tr>
                                                        <td>@lang('admin.request.hours_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->hour) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('admin.request.distance_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->distance) }}</td>
                                                    </tr>
                                                    @endif

                                                    <tr>
                                                        <td>@lang('admin.request.provider_earnings')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->provider_pay - $request->payment->discount) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.commission')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->commision) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.fleet_commission')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->fleet) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.discount_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->discount) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.peak_amount')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->peak_amount) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.peak_commission')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->peak_comm_amount) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.waiting_charge')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->waiting_amount) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.waiting_commission')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->waiting_comm_amount) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.tax_price')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->tax) }}</td>
                                                    </tr>


                                                    <tr>
                                                        <td>@lang('admin.request.tips')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->tips) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('user.ride.round_off')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->round_of) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.total_amount')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->total+$request->payment->tips) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('admin.request.wallet_deduction')</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ currency($request->payment->wallet) }}</td>
                                                    </tr>

                                                    @endif


                                                    <tr>
                                                        <!--
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Subtotal</strong></td>
                                                            <td class="thick-line text-right">$670.99</td>
                                                        </tr>
                                                        -->

                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Total</strong></td>
                                                                <td class="no-line text-right">
                                                                    @if($request->payment->payment_mode=='CARD')
                                                                    <h4 class="m-0">{{ currency($request->payment->card) }}</h4>
                                                                    @else
                                                                    <h4 class="m-0">{{ currency($request->payment->cash) }}</h4>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--
                                                <div class="d-print-none">
                                                    <div class="float-right">
                                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection


