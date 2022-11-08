@extends('admin.layout.app')

@section('title', 'Tipos de Disputas ')
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

                            @can('dispute-type-create')
                            <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">
                                    <a href="{{ route('admin.dispute.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.dispute.add_dispute')</a>
                                </div>
                            </div>
                            @endcan

                        </div>
                        <br>
                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>@lang('admin.dispute.dispute_type') </th>
                                        <th>@lang('admin.dispute.dispute_name') </th>                             
                                        <th>@lang('admin.status')</th>                         
                                        <th width="200">@lang('admin.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dispute as $index => $dist)
                                    <tr>
                                        <td>{{ $dist->dispute_type == "provider" ? "Motorista" : "Passageiro" }}</td>
                                        <td>{{ ucfirst($dist->dispute_name) }} </td>
                                        <td>
                                            @if($dist->status=='active')
                                            <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i>@lang('admin.active')</span>
                                            @else
                                            <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> @lang('admin.inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('dispute-type-edit')
                                            <a href="{{ route('admin.dispute.edit', $dist->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                            @endcan
                                            @can('dispute-type-delete')
                                            <button href="{{ route('admin.dispute.destroy', $dist->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{ ucfirst($dist->dispute_name) }}"  class="btn btn-danger" data-title="Deseja realmente excluir esse tipo de disputa?"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
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