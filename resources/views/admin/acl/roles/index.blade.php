@extends('admin.layout.app')

@section('title', 'Papéis')

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
                                    @can('role-create')
                                    <a href="{{ route('admin.acl.role.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Adicionar Papel</a>
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
                                    <th>Flag</th>
                                    <th>Permissões</th>
                                    <th>Número de Usuários</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a href="javascript:void(0)" style="cursor:pointer;" onclick="$('#role_{{ $role->id }}').animate({ height: 'toggle' }, 500 );">Mostrar/Ocultar Permissões</a>
                                          <div id="role_{{ $role->id }}" style="font-size:.8em; display: none;">
                                          <blockquote>
                                            @if($role->id == 0)
                                               Todas as Permissões
                                            @endif
                                            @foreach($role->permissions as  $permission)              
                                                {{ $permission->display_name }} <br>
                                            @endforeach
                                            </blockquote>
                                          </div>

                                    </td>
                                    <td>{{ $role->users->count() }}</td>
                                
                                    <td width="200" class="">
                                        @if($role->id > 2 || Auth::user()->isSuperAdmin())
                                            @can('role-edit')
                                            <a href="{{ route('admin.acl.role.edit', $role->id) }}"  class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                            @endcan
                                            @if($role->id > 6)
                                            @can('role-delete')
                                            <button  href="{{ route('admin.acl.role.destroy', $role->id) }}"  class="btn btn-danger  waves-effect waves-light" data-method="delete" data-long-text="{{ $role->name }}"  class="btn btn-danger" data-title="Deseja realmente excluir permanentimente esse papel?"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                            @endcan
                                            @endif
                                        @endif
                                        
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

