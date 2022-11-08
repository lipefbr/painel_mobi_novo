@extends('admin.layout.app')

@section('title', 'Franquias')

@section('styles')
<link href="{{ url('asset/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">
                                    @can('fleet-create')
                                    <a href="{{ route('admin.fleet.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Nova Franquia</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <br>
                         <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('admin.picture')</th>
                                    <th>Nome da Franquia</th>
                                    <th>@lang('admin.city')</th>
                                    <th>@lang('admin.mobile')</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fleets as $index => $fleet)
                                <tr>
                                    <td><img src="{{img($fleet->logo)}}" class="thumb-md rounded-circle mr-2"></td>
                                    <td>{{ $fleet->name }}</td>
                                    <td>{{ isset($fleet->city) ? $fleet->city->title : '' }}</td>
                                    <td>{{ $fleet->admin->mobile }}</td>
                                    <td width="300">
                                            
                                            @can('fleet-edit')
                                            <a href="{{ route('admin.fleet.edit', $fleet->id) }}" class="btn btn-primary"><i class="far fa-edit"></i> @lang('admin.edit')</a>
                                            @endcan
                                            @can('fleet-manage')
                                            <a href="{{ route('admin.fleet.show', $fleet->id) }}" class="btn btn-info"><i class="far fa-sun"></i> Gerenciar</a>
                                            @endcan

                                            @can('fleet-delete')
                                            <button href="{{ route('admin.fleet.destroy', $fleet->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$fleet->name}}"  class="btn btn-danger" data-title="Deseja realmente excluir essa franquia?"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                            @endcan
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
@endsection

@section('scripts')

<script src="{{ url('asset/js/sweetalert2/sweetalert2.js') }}"></script>
@endsection

