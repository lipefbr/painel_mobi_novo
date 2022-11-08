@extends('admin.layout.app')

@section('title', 'Cupons Promocionais ')

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">

                            @can('promocodes-create')
                            <div class="col-sm-12">
                                <div class="col-xs-12 d-flex justify-content-end">

                                    <a href="{{ route('admin.promocode.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.promocode.add_promocode')</a>
                                </div>
                            </div>
                            @endcan
                        </div>
                        <br>
                         <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('admin.promocode.promocode') </th>
                                    <th>@lang('admin.promocode.percentage') </th>
                                    <th>@lang('admin.promocode.max_amount') </th>
                                    <th>@lang('admin.promocode.expiration')</th>
                                    <th>@lang('admin.status')</th>
                                    <th>@lang('admin.promocode.used_count')</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promocodes as $index => $promo)
                                <tr>
                                    <td>{{$promo->promo_code}}</td>
                                    <td>{{$promo->percentage}}</td>
                                    <td>{{$promo->max_amount}}</td>
                                    <td>
                                        {{ date('d/m/Y H:i:s' , strtotime($promo->expiration)) }}

                                    </td>
                                    <td>
                                        @if(date("Y-m-d H:i") <= $promo->expiration)
                                        <span class="tag tag-success">Válido</span>
                                        @else
                                        <span class="tag tag-danger">Expirado</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{promo_used_count($promo->id)}}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.promocode.destroy', $promo->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            @if( Setting::get('demo_mode', 0) == 0)
                                            @can('promocodes-edit')
                                            <a href="{{ route('admin.promocode.edit', $promo->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Editar</a>
                                            @endcan
                                            @can('promocodes-delete')
                                            <button class="btn btn-danger" onclick="return confirm('Você tem certeza?')"><i class="fa fa-trash"></i> Excluir</button>
                                            @endcan
                                            @endif
                                        </form>
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