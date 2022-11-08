@extends('admin.layout.app')


@section('styles')
<link href="{{ url('asset/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('title', 'Usuários')

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
                                    @can('role-view')
                                    <a href="{{ route('admin.acl.roles') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fas fa-cog"></i> Gerenciar Papéis</a>
                                    @endcan
                                    @can('admin-user-create')
                                    <a href="{{ route('admin.acl.user.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Adicionar Usuário</a>
                                    @endcan
                                </div>
                            </div>



                        </div>
                        <br>
                        <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>@lang('admin.email')</th>
                                    <th>@lang('admin.mobile')</th>
                                    <th>Papéis</th>
                                    <th>Status</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                @if(!$user->isSuperadmin() || Auth::user()->isSuperAdmin())
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>

                                    <td>
                                        @foreach($user->roles  as  $role)
                                            {{ $role->display_name }} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($user->active)
                                           <span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i>ATIVO</span>
                                        @else
                                            <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i>INATIVO</span>
                                        @endif

                                    </td>
                                
                                    <td width="200">
                                            @can('admin-user-edit')
                                            <a href="{{ route('admin.acl.user.edit', $user->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                            @endcan
                                            @can('admin-user-delete')
                                            <button href="{{ route('admin.acl.user.destroy', $user->id) }}" class="btn btn-danger"  data-method="delete" data-long-text="{{$user->name}} - {{ $user->email }}"  class="btn btn-danger" data-title="Deseja realmente excluir esse usuário?"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                            @endcan
                                    </td>
                                </tr>
                                @endif
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


