@extends('admin.layout.app')

@section('title', 'Solicitações de Disputa ')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">

                            @can('dispute-create')
                            <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">
                                    <a href="{{ route('admin.userdisputecreate') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.dispute.add_dispute')</a>
                                </div>
                            </div>
                            @endcan
                        </div>
                        <br>
                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>@lang('admin.dispute.dispute_request') </th>
                                        <th>@lang('admin.users.name') </th>                           
                                        <th>@lang('admin.dispute.dispute_request_id') </th>
                                        <th>@lang('admin.dispute.dispute_name') </th>                           
                                        <th>@lang('admin.dispute.dispute_comments') </th>                           
                                        <th>@lang('admin.dispute.dispute_refund') </th>                           
                                        <th>@lang('admin.dispute.dispute_status') </th>                           
                                        <th>@lang('admin.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($disputes as $index => $dispute)
                                    <tr>
                                        <td>{{ $dispute->dispute_type == "provider" ? "Motorista" : "Passageiro" }}</td>
                                        <td>@if($dispute->dispute_type=='user') @if($dispute->user != null) {{ $dispute->user->first_name." ".$dispute->user->last_name }} @endif @else  @if($dispute->provider != null)  {{ $dispute->provider->first_name." ".$dispute->provider->last_name }} @endif @endif</td>
                                        <td>{{ $dispute->request->booking_id }}</td>
                                        <td>{{ $dispute->dispute_name }}</td>
                                        <td>{{ $dispute->comments }}</td>
                                        <td>{{ currency($dispute->refund_amount) }}</td>
                                        <td>
                                            @if($dispute->status=='open')
                                            <span class="tag tag-success">Aberta</span>
                                            @else
                                            <span class="tag tag-danger">Finalizada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('dispute-edit')
                                            @if($dispute->status=='open')
                                            <a href="{{ route('admin.userdisputeedit', $dispute->id) }}" href="#" class="btn btn-info"><i class="fa fa-pencil"></i> Analizar</a>
                                            @endif   
                                            @endcan 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('common.pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection