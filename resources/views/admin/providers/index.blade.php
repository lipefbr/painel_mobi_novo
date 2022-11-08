@extends('admin.layout.app')

@section('title', 'Motoristas ')

@section('content')


<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-8">

                                <form action="{{ route('admin.provider.index') }}" method="get">

                                    <div class="form-group row col-sm-12" style="padding-left:0 !important; padding-right:0 !important; margin-bottom: 20px;">
                                        <div class="col-sm-4">
                                            <input name="name" type="text" class="form-control" placeholder="Nome do Motorista" aria-label="Nome do Motorista" aria-describedby="basic-addon2">
                                        </div>

                                        <div class="col-sm-5" style="padding-top: 8px">
                                            <label class="radio-inline">
                                                <input type="radio" name="status" value="A" class="radio"{{ request()->has('status')&&request()->get('status')=="A"?" checked":"" }}> Regularizados
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" value="P" class="radio"{{ request()->has('status')&&request()->get('status')=="P"?" checked":"" }}> Docs Pendentes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" value="F" class="radio"{{ request()->has('status')&&request()->get('status')=="F"?" checked":"" }}> Falta Docs
                                            </label>
                                        </div>

                                        <div class="col-sm-3">
                                            <button class="btn btn-primary" type="submit">Pesquisar</button>
                                        </div>
                                    </div>                
                                </form>
                            </div> 


                            @can('provider-create')
                            <div class="col-sm-4">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <a href="{{ route('admin.provider.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.provides.add_new_provider')</a>
                                </div>
                            </div>
                            @endcan

                        </div>
                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>@lang('admin.provides.full_name')</th>
                                        <th>@lang('admin.email')</th>
                                        <th>@lang('admin.mobile')</th>
                                        <th>@lang('admin.users.Wallet_Amount')</th>
                                        <th>@lang('admin.provides.total_requests')</th>
                                        <th>@lang('admin.provides.accepted_requests')</th>
                                        <th>@lang('admin.provides.created_at')</th>
                                        @can('provider-status')
                                        <th >@lang('admin.provides.service_type')</th>
                                        @endcan
                                        <th>@lang('admin.provides.online')</th>
                                        <th>@lang('admin.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($providers as $index => $provider)

                                    <tr>
                                        <td>{{ $provider->first_name }} {{ $provider->last_name }}</td>

                                        <td>{{ $provider->email }}</td>
                                        <td>{{ $provider->mobile }}</td>
                                        <td>
                                            @can('provider-wallet')
                                                @if($provider->wallet_balance < 0)
                                                <span class="badge badge-light text-danger"> {{ currency($provider->wallet_balance) }} </span>
                                                @elseif($provider->wallet_balance == 0)
                                                <span class="badge badge-light text-warning"> {{ currency($provider->wallet_balance) }} </span>
                                                @else
                                                <span class="badge badge-light text-primary"> {{ currency($provider->wallet_balance) }} </span>
                                                @endif
                                            @else
                                            R$ ****
                                            @endcan
                                        </td>
                                        <td>{{ $provider->total_requests() }}</td>
                                        <td>{{ $provider->accepted_requests() }}</td>
                                        <td>{{ $provider->created_at->format('d/m/Y H:i:s') }}</td>
                                        @can('provider-status')
                                        <td>
                                            @if($provider->active_documents() == $total_documents && $provider->service != null)

                                           <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> VERIFICADO</span>

                                            @else
                                            <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> PENDENTE</span>

                                            @endif
                                        </td>
                                        @endcan
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
                                                @can('provider-active')
                                                @if($provider->status == 'approved')
                                                <a class="btn btn-danger btn-block" href="{{ route('admin.provider.disapprove', $provider->id ) }}">Desativar</a>
                                                @else
                                                <a class="btn btn-success btn-block" href="{{ route('admin.provider.approve', $provider->id ) }}">Aprovar</a>
                                                @endcan
                                                @endif
                                                
                                                @can('provider-details')
                                                <a class="btn btn-primary waves-effect waves-light btn-block" href="{{ route('admin.provider.show', $provider->id) }}">Detalhes</a>
                                                @endcan

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>@lang('admin.provides.full_name')</th>
                                        <th>@lang('admin.email')</th>
                                        <th>@lang('admin.mobile')</th>
                                        <th>@lang('admin.users.Wallet_Amount')</th>
                                        <th>@lang('admin.provides.total_requests')</th>
                                        <th>@lang('admin.provides.accepted_requests')</th>
                                        <th>@lang('admin.provides.created_at')</th>
                                        @can('provider-status')
                                        <th>@lang('admin.provides.service_type')</th>
                                        @endcan
                                        <th>@lang('admin.provides.online')</th>
                                        <th>@lang('admin.action')</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @include('common.pagination')

                    </div>
                </div>
            </div>
            @endsection

            @section('scripts')
            <script type="text/javascript">
                jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {
                    if ( this.context.length ) {
                        var jsonResult = $.ajax({
                            url: "{{url('admin/provider')}}?page=all&{{ request()->has('fleet')?'fleet='.request()->get('fleet'):'' }}",
                            data: {},
                            success: function (result) {
                                p = new Array();
                                $.each(result.data, function (i, d)
                                {
                                    var item = [d.id,d.first_name +' '+ d.last_name, d.email,d.mobile,d.rating, d.wallet_balance];
                                    p.push(item);
                                });
                            },
                            async: false
                        });
                        var head=new Array();
                        head.push("ID", "Nome", "Email", "Mobile", "Rating", "Wallet");
                        return {body: p, header: head};
                    }
                } );

                $('#table-5').DataTable( {
                    responsive: true,
                    paging:false,
                    info:false,
                    dom: 'Bfrtip',
                    buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                    ]
                } );
            </script>
            @endsection
