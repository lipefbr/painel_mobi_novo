@extends('admin.layout.app')


@section('title', 'Financeiro | Visão Geral')

@section('styles')
<link rel="stylesheet" href="{{ url('agroxa/plugins/morris/morris.css') }}">
@endsection
@section('content')

            <div class="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary mini-stat position-relative">
                                <div class="card-body">
                                    <div class="mini-stat-desc">
                                        <h6 class="text-uppercase verti-label text-white-50">CAIXA</h6>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mt-0 text-white-50">CAIXA</h6>
                                            <h3 class="mb-3 mt-0">{{ currency($totalAcount) }}</h3>
                                            <div class="">
                                                <!--
                                                <span class="badge badge-light text-info"> +11% </span>
                                                -->
                                                <span>Somatório disponível em caixa</span>
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
                                        <h6 class="text-uppercase verti-label text-white-50">COMISSÃO</h6>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mt-0 text-white-50">COMISSÕES</h6>
                                            <h3 class="mb-3 mt-0">{{ currency($totalComissions) }}</h3>
                                            <div class="">
                                                <!--
                                                <span class="badge badge-light text-danger"> -29% </span> 
                                                -->
                                                <span>Somatório de comissões</span>
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
                                        <h6 class="text-uppercase verti-label text-white-50">MOTORIS..</h6>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mt-0 text-white-50">MOTORISTAS</h6>
                                            <h3 class="mb-3 mt-0">{{ currency($totalDriver) }}</h3>
                                            <div class="">
                                                <!--
                                                <span class="badge badge-light text-primary"> 0% </span> 
                                                -->
                                                <span>Somatório da carteira de motoristas</span>
                                            </div>
                                        </div>
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
                                        <h6 class="text-uppercase verti-label text-white-50">SAQUES</h6>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mt-0 text-white-50">SAQUES</h6>
                                            <h3 class="mb-3 mt-0">{{ currency($wallterRequestsPending) }}</h3>
                                            <div class="">
                                                <!--
                                                <span class="badge badge-light text-info"> +89% </span>
                                                -->
                                                <span>Saques Pendentes</span>
                                            </div>
                                        </div>
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-briefcase-check display-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-8 border-right">
                                            <h4 class="mt-0 header-title mb-4">Receita de Viagens</h4>
                                            <div id="morris-area-example" class="dashboard-charts morris-charts"></div>
                                        </div>
                                        <div class="col-xl-4">
                                            <h4 class="header-title mb-4">Somatório de Receitas de Viagens</h4>
                                            <div class="p-3">
                                                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link  @if(!request()->period == 'month') btn-primary @else btn-light @endif" href="{{ route('admin.financial.overview') }}" >7 Dias</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class=" nav-link  @if(request()->period == 'month') btn-primary @else btn-light @endif" href="{{ route('admin.financial.overview') }}?period=month">30 Dias</a>
                                                    </li>
                                                </ul>
                                                <br>
                                                <h2>{{ currency($arrRecipes['amount']) }}</h2>
                                            </div>
                                            <div>
                                            <h6>Legenda:</h6>
                                            <div><svg height="16" width="16"><circle cx="10" cy="10" r="6" fill="#388e3c"/></svg>  <sapn class="ml-2">Viagens Concluidas</span></div>
                                             <div><svg height="16" width="16"><circle cx="10" cy="10" r="6" fill="#ffd600"/></svg> <sapn class="ml-2">Comissão de Viagens</span></div>
                                             </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title mb-4">Solicitações de Saques</h4>
                                    <div class="table-responsive order-table">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Data</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" width="280">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($wallterRequests as $wallterRequest)

                                                @if($wallterRequest->request_from == 'provider')
                                                    @cannot('financial-withdrawals-driver')
                                                        @continue
                                                    @endcan
                                                @else
                                                    @if($wallterRequest->request_from == 'fleet')
                                                        @cannot('financial-withdrawals-fleet')
                                                            @continue
                                                        @endcan
                                                    @endif
                                                @endif
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
                                                        @if($wallterRequest->request_from == 'provider')
                                                            Motorista
                                                        @else
                                                            @if($wallterRequest->request_from == 'fleet')
                                                            Franquia
                                                            @else
                                                            N/A
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td><span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Aguardando</span></td>
                                                    <td>
                                                        <div class="button-items">
                                                            @can('financial-withdrawals-details')
                                                             @if($wallterRequest->request_from == 'provider')
                                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.provider.show', $wallterRequest->from_id) }}">Detalhes</a>
                                                             @else
                                                                @if($wallterRequest->request_from == 'fleet')
                                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.fleet.show', $wallterRequest->from_id) }}">Detalhes</a>
                                                                @endif
                                                            @endif
                                                            @endcan

                                                            @can('financial-withdrawals-send')
                                                             <button type="button" class="btn btn-primary waves-effect waves-light approve" data-toggle="modal" data-target=".bs-modal-confirm" data-href="{{route('admin.approve.confirm', $wallterRequest->id) }}" data-rid="{{$wallterRequest->id}}">@lang('admin.approve')</button>
                                                             @endcan
                                                            @can('financial-withdrawals-send')
                                                            <button type="button" class="btn btn-danger waves-effect waves-light recuse" data-toggle="modal" data-target=".bs-modal-recuse" data-id="cancel" data-href="{{ route('admin.cancel') }}?id={{$wallterRequest->id}}" data-rid="{{$wallterRequest->id}}">Recusar</button>
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
                        </div>
                    </div>


  
            </div>
        </div>
    </div>

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

<script type="text/javascript">

    $(".recuse").click(function () {
        $('#form-cancel').attr('action', $(this).attr('data-href'));
        $("#transfer_id").val($(this).attr('data-rid'));

    });
    
    $(".approve").click(function () {
        $('#form-approve').attr('action', $(this).attr('data-href'));
        //$("#transfer_id").val($(this).attr('data-rid'));

    });
    
    //creating area chart
        var $areaData = [
            @foreach($arrRecipes['data'] as $recipe)
            {y: "{!! $recipe['date'] !!}", a: {{ $recipe['recipe'] }}, b: {{ $recipe['comission'] }} },
            @endforeach
        ];

        
        Morris.Area({
            element: 'morris-area-example',
            pointSize: 0,
            lineWidth: 0,
            data: $areaData,
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Receita', 'Comissao'],
            resize: true,
            gridLineColor: '#eee',
            hideHover: 'auto',
            lineColors: ['#f5b225', '#35a989'],
            fillOpacity: .7,
            behaveLikeLine: true,
            xLabelFormat: function (d) {

               return ("0" + d.getDate()).slice(-2) + '/' + ("0" + (d.getMonth() + 1)).slice(-2);
  
            },
        });

</script>

@endsection

