@extends('admin.layout.app')

@section('title', 'Documentos ')

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
                @can('documents-create')
                <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">

                    <a href="{{ route('admin.document.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.document.add_Document')</a>
                    </div>
                            </div>
                @endcan
                </div>
                        <br>
                 <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>@lang('admin.document.document_name')</th>
                            <th>@lang('admin.type')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($documents as $index => $document)
                        <tr>
                            <td>{{$document->name}}</td>
                            <td>{{$document->type == "VEHICLE" ? "VEÍCULO" : "MOTORISTA"}}</td>
                            <td width="200">
                            @can('documents-edit')
                            <a href="{{ route('admin.document.edit', $document->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                            @endcan
                            @can('documents-delete')
                            <button href="{{ route('admin.document.destroy', $document->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$document->name}}"  class="btn btn-danger" data-title="Deseja realmente excluir esse documento?"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
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

