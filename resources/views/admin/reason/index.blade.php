@extends('admin.layout.app')

@section('title', 'Motivos de Cancelamento ')


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

                            @can('cancel-reasons-create')
                            <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">
                                <a href="{{ route('admin.reason.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.reason.add_reason')</a>
                            </div>    
                            </div>    
                            @endcan

                        </div>
                        <br>
                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>@lang('admin.reason.type') </th>
                            <th>@lang('admin.reason.reason') </th>
                            <th>@lang('admin.reason.status') </th>
                            <th width="200">@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reasons as $index => $reason)
                        <tr>
                            <td>{{$reason->type == 'PROVIDER' ? "MOTORISTA" : "PASSAGEIRO"}}</td>
                            <td>{{$reason->reason}}</td>
                            <td>
                                @if($reason->status==1)
                                    <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i>ATIVO</span>
                                @else
                                    <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i>INATIVO</span>
                                @endif
                            </td>
                            <td width="190">
                                    @can('cancel-reasons-edit')
                                    <a href="{{ route('admin.reason.edit', $reason->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Editar</a>
                                    @endcan
                                    @can('cancel-reasons-delete')
                                    <button href="{{ route('admin.reason.destroy', $reason->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$reason->reason}}"  class="btn btn-danger" data-title="Deseja realmente excluir esse motivo de cancelamento?"><i class="fa fa-trash"></i> Excluir</button>
                                    @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>@lang('admin.reason.type') </th>
                            <th>@lang('admin.reason.reason') </th>
                            <th>@lang('admin.reason.status') </th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection

@section('scripts')

<script src="{{ url('asset/js/sweetalert2/sweetalert2.js') }}"></script>
@endsection

