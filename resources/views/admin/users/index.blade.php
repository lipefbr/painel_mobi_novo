@extends('admin.layout.app')

@section('title', 'Passageiros ')
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
                            <div class="col-sm-6">
                                <form action="{{ route('admin.user.index') }}" method="get">
                                    <div class="form-group row col-md-9" style="padding-left:0 !important; padding-right:0 !important; ">
                                        <div class="col-sm-8" >
                                            <input name="name" type="text" class="form-control" placeholder="Nome do Passageiro ou Email" aria-label="Nome do Passageiro" aria-describedby="basic-addon2">
                                        </div>

                                        <div class="col-sm-4" style="padding-left:0 !important; padding-right:0 !important; ">
                                            <button class="btn btn-primary" type="submit" >Pesquisar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            @can('user-create')
                            <div class="col-sm-6">
                                <div class="col-xs-12 d-flex justify-content-end">
                                    <a href="{{ route('admin.user.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Adicionar Novo</a>
                                </div>    
                            </div>
                            @endcan

                        </div>

                       <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('admin.first_name')</th>
                                    <th>@lang('admin.email')</th>
                                    <th>@lang('admin.mobile')</th>
                                    <th>@lang('admin.users.Rating')</th>
                                    <th>@lang('admin.users.Wallet_Amount')</th>
                                    <th width="300">@lang('admin.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($page = ($pagination->currentPage-1)*$pagination->perPage)
                                @foreach($users as $index => $user)
                                @php($page++)
                                <tr>
                                    <td>
                                        <div>
                                            <img src="{{img($user->picture)}}" alt="" class="thumb-md rounded-circle mr-2"> {{$user->first_name}} {{$user->last_name}}
                                        </div>

                                    </td>
                                    @if(Setting::get('demo_mode', 0) == 1)
                                    <td>{{ substr($user->email, 0, 3).'****'.substr($user->email, strpos($user->email, "@")) }}</td>
                                    @else
                                    <td>{{ $user->email }}</td>
                                    @endif
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ $user->rating }}</td>
                                    <td>
                                        @can('user-wallet')
                                        {{currency($user->wallet_balance)}}
                                        @else
                                        R$ ****
                                        @endcan
                                    </td>
                                    <td>
                                        
                                        @can('user-edit')
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary"><i class="far fa-edit"></i> @lang('admin.edit')</a>
                                        @endcan

                                        @can('user-details')
                                         <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-info"><i class="far fa-sun"></i> Detalhes</a>
                                         @endif

                                        @can('user-delete')
                                        <button href="{{ route('admin.user.destroy', $user->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{$user->first_name}} {{$user->last_name}} - {{ $user->email }}"  class="btn btn-danger" data-title="Deseja realmente excluir esse usuário?"><i class="far fa-trash-alt"></i> @lang('admin.delete')</button>
                                        @endcan

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>@lang('admin.first_name')</th>
                                    <th>@lang('admin.email')</th>
                                    <th>@lang('admin.mobile')</th>
                                    <th>@lang('admin.users.Rating')</th>
                                    <th>@lang('admin.users.Wallet_Amount')</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                        @include('common.pagination')
                    
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

<script type="text/javascript">
    /**
    jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {
        if ( this.context.length ) {
            var jsonResult = $.ajax({
                url: "{{url('admin/user')}}?page=all",
                data: {},
                success: function (result) {
                    p = new Array();
                    $.each(result.data, function (i, d)
                    {
                        var item = [d.id,d.first_name, d.last_name, d.email,d.mobile,d.rating, d.wallet_balance];
                        p.push(item);
                    });
                },
                async: false
            });
            var head=new Array();
            head.push("ID", "First Name", "Last Name", "Email", "Mobile", "Rating", "Wallet Amount");
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
    *//
</script>
@endsection
