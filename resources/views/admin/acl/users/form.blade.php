@extends('admin.layout.app')

@if( is_null($user) )
@section('title', 'Cadastrar Usuário')
@else
@section('title', 'Editar Usuário')
@endif

@section('styles')
<link href="{{ url('agroxa/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                @if( is_null($user) )
                {!! Form::open(['route' => ['admin.acl.user.store'], 'id' => 'create-user', 'method' => 'post', 'enctype' =>'multipart/form-data' ]) !!}
                @else
                {!! Form::model($user, ['route' => ['admin.acl.user.update', $user->id ], 'id' => 'edit-user', 'method' => 'PUT', 'enctype' =>'multipart/form-data']) !!}
                @endif

                <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">@lang('admin.account-manager.full_name')</label>
                    <div class="col-sm-10">
                        {!! form::text('name', null, ['class' => 'form-control validate', 'disabled' => $disabled, 'required', 'id' => 'name']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">@lang('admin.email')</label>
                    <div class="col-sm-10">
                        {!! form::email('email', null, ['class' => 'form-control validate', 'disabled' => $disabled, 'required', 'id' => 'email']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">@lang('admin.password')</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="password" id="password" placeholder="@lang('admin.password')">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">@lang('admin.account-manager.password_confirmation')</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('admin.dispute-manager.password_confirmation')">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">CPF / Telefone</label>
                    <div class="col-sm-5">
                        {!! form::text('cpf', null, ['class' => 'form-control validate cpf', 'disabled' => $disabled, 'required', 'id' => 'cpf', 'placeholder' => '000.000.000-00']) !!}

                    </div>
                    <div class="col-sm-5">
                        {!! form::text('mobile', null, ['class' => 'form-control validate cell_phone', 'disabled' => $disabled, 'required', 'id' => 'mobile', 'placeholder' => '(00) 0 0000-0000']) !!}
                    </div>    
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Franquias Vinc.</label>
                    <div class="col-sm-10" style="margin-bottom: 15px">
                        {!! Form::select('fleets[]', $fleets , null, [ 'style' => 'width: 100%;', 'disabled' => $disabled, 'multiple', 'class' => 'select2 form-control select2-multiple', 'data-placeholder' => "Vincular franquias"]) !!}
                    </div>  
                </div>  
                <br>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ativo/Inativo</label>
                    <div class="col-sm-10">
                        <div class="float-xs-left mr-1">

                            @if( is_null($user) )
                                <input name="active" type="checkbox" class="js-switch" data-color="#43b968" id="active" switch="none" checked />
                                <label for="active" data-on-label="SIM"
                                data-off-label="NÃO"></label>
                            @else
                                <input name="active" type="checkbox" class="js-switch" data-color="#43b968" id="active" switch="none" @if($user->active) checked  @endif/>
                                <label for="active" data-on-label="SIM"
                                data-off-label="NÃO"></label>
                            @endif
                        </div>
                    </div>
                </div>

                <br>
                <div class="form-group row">
                    <label for="mobile" class="col-sm-2 col-form-label">Papéis</label>
                    <div class="col-sm-10">

                    @foreach($roles as $role)
                    @if(Auth::user()->isSuperAdmin() || (Auth::user()->isAdmin() && $role->id != 1) || (Auth::user()->isFleetManage() && $role->id != 1 &&  $role->id != 2 &&  $role->id != 6))
                    <p style="margin-bottom: 5px">
                        <label for="filled-in-box-{{ $role->id }}">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="filled-in" @if(!is_null($disabled)) disabled @endif id="filled-in-box-{{ $role->id }}" {{ in_array($role->id, $user_role) ? 'checked' : ''}} />
                            <span>{{ $role->display_name }}</span>
                        </label>
                        <a href="javascript:void(0)" style="cursor:pointer;" onclick="$('#role_{{ $role->id }}').animate({ height: 'toggle' }, 500 );"><small> (Mostrar/Ocultar Permissões)</small></a>
                        
                    </p>
                    <div>
                        <div id="role_{{ $role->id }}" style="margin-left: 50px; font-size:.8em; display: none;">
                            <blockquote>

                                @if($role->id == 1)
                                Todas as Permissões
                                @endif
                                @foreach($role->permissions as  $permission)
                                
                                {{ $permission->display_name }} <br>
                                @endforeach
                            </blockquote>
                        </div>

                    </div>
                    <br>
                    @endif
                    @endforeach
                    </div>
                </div>

                </div>

                <div class="card-footer d-flex justify-content-end">
                    @if( is_null($user) )
                        <button type="submit" class="btn btn-primary">Adicionar Usuário</button>
                    @else
                        <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
                    @endif
                    </div>
                </div>
                
           
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
</div>

@endsection

@section('scripts')

<script src="{{ url('asset/js/mask/jquery-mask-as-number.js') }}"></script>
<script src="{{ url('asset/js/mask/jquery.mask.js') }}"></script>
<script src="{{ url('agroxa/plugins/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    
    $('.cell_phone').mask('(00) 0 0000-0000');
    $('.phone').mask('(00) 0000-0000');
    $('.cpf').mask('000.000.000-00');

    $(".select2").select2();
    //$(".select2").select2({ width: '300px'});


    $(".select2-limiting").select2({
        maximumSelectionLength: 2
    });

</script>
@endsection
