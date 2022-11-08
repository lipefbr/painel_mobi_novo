@extends('admin.layout.app')

@section('title', 'Itens Perdidos ')

@section('content')


<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                    <div class="card-body">

                        <div class="row ">


                            @can('lost-item-create')
                            <div class="col-sm-12 d-flex justify-content-end form-group">
                                <a href="{{ route('admin.lostitem.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.lostitem.add')</a>
                            </div>    
                            @endcan

                        </div>

                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">


                                <thead>
                                    <tr>
                                        <th>@lang('admin.lostitem.lost_user') </th>                           
                                        <th>@lang('admin.lostitem.lost_item') </th>
                                        <th>@lang('admin.lostitem.lost_comments') </th>                           
                                        <th>@lang('admin.lostitem.lost_status') </th>                           
                                        <th>@lang('admin.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lostitem as $index => $lost)
                                    <tr>
                                        <td>{{ $lost->user->getFullNameAttribute() }}</td>
                                        <td>{{ $lost->lost_item_name }}</td>
                                        <td>{{ $lost->comments }}</td>
                                        <td>
                                            @if($lost->status=='open')
                                            <span class="tag tag-success">Aberto</span>
                                            @else
                                            <span class="tag tag-danger">Fechado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('lost-item-edit')
                                            @if($lost->status=='open')
                                            <a href="{{ route('admin.lostitem.edit', $lost->id) }}" href="#" class="btn btn-info"><i class="fa fa-pencil"></i> Editar</a>
                                            @endif   
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
    @endsection