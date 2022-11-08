[@extends('admin.layout.app')

@section('title', 'Serviços')

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
                            @can('service-types-create')
                            <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">

                                    <a href="{{ route('admin.service.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Adicionar Novo Serviço</a>

                                </div>
                            </div>
                            @endcan
                        </div>
                        <br>
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
                                    <th>Preço Distância</th>
                                    <th>Preço Tempo</th>
                                    <th>Preço Hora</th>
                                    <th>Cáuculo de Preço</th>
                                    <th>Marker Mapa</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fleets as $fleet)
                                <tr>
                                    <td colspan="11"><b>{{ $fleet->name }}</b></td>
                                </tr>
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
                                    <td>
                                        <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            @if( Setting::get('demo_mode', 0) == 0)
                                            @can('service-types-edit')
                                            <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-info btn-block">
                                                <i class="fa fa-pencil"></i> Editar
                                            </a>
                                            @endcan
                                            @can('service-types-delete')
                                            <button class="btn btn-danger btn-block" onclick="return confirm('Você tem certeza?')">
                                                <i class="fa fa-trash"></i> Excluir
                                            </button>
                                            @endcan
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome do Serviço</th>
                                    <th>Capacidade</th>
                                    <th>Tarifa Mínima</th>
                                    <th>Preço Base</th>
                                    <th>Distância Base</th>
                                    <th>Preço Distância</th>
                                    <th>Preço Tempo</th>
                                    <th>Preço Hora</th>
                                    <th>Cáuculo de Preço</th>
                                    <th>Marker Mapa</th>
                                    <th>Ação</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            @endsection
            ]