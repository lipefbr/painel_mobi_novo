@extends('admin.layout.app')

@section('title', 'Atualizar Perfil ')

@section('styles')
<link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                      <form class="form-horizontal" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
                            {{csrf_field()}}

                    <div class="card-body">

                            <div class="form-group row">

                                <label for="name" class="col-sm-2 col-form-label">@lang('admin.name')</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="{{ Auth::guard('admin')->user()->name }}" name="name" required id="name" placeholder=" @lang('admin.name')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">@lang('admin.email')</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="email" required name="email" value="{{ isset(Auth::guard('admin')->user()->email) ? Auth::guard('admin')->user()->email : '' }}" id="email" placeholder="@lang('admin.email')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">CPF / Telefone</label>
                                <div class="col-sm-5">
                                    <input class="form-control cpf" type="text" required name="cpf" value="{{ isset(Auth::guard('admin')->user()->cpf) ? Auth::guard('admin')->user()->cpf : '' }}"  placeholder="CPF">
                                </div>
                                <div class="col-sm-5">
                                     <input class="form-control cell_phone" type="text" required name="mobile" value="{{ isset(Auth::guard('admin')->user()->mobile) ? Auth::guard('admin')->user()->mobile : '' }}"  placeholder="Telefone">
                                </div>    
                            </div>
                            <div class="form-group row">
                                <label for="picture" class="col-sm-2 col-form-label">@lang('admin.picture')</label>
                                <div class="col-sm-10">
                                    @if(isset(Auth::guard('admin')->user()->picture))
                                    <img style="height: 90px; margin-bottom: 15px;" class="rounded-circle" src="{{img(Auth::guard('admin')->user()->picture)}}">
                                    @endif
                                    <input type="file" accept="image/*" name="picture" class=" dropify form-control-file" aria-describedby="fileHelp">
                                </div>
                            </div>
                           
                            
                        
                    </div>
                    @can('account-update')
                    <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">@lang('admin.account.update_profile')</button>
                    </div>
                    @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<br>
<br>
<br>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <form class="form-horizontal" action="{{route('admin.password.update')}}" method="POST" role="form">
                    {{csrf_field()}}
                    <div class="card-body">

                            <div class="form-group row">
                                <label for="old_password" class="col-sm-2 col-form-label">@lang('admin.account.old_password')</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" name="old_password" id="old_password" placeholder="@lang('admin.account.old_password')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">@lang('admin.account.password')</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" name="password" id="password" placeholder="@lang('admin.account.password')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_confirmation" class="col-sm-2 col-form-label">@lang('admin.account.password_confirmation')</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('admin.account.password_confirmation')">
                                </div>
                            </div>
                    
                    </div>
                    @can('account-update-pass')
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Atualizar Senha</button>
                    </div>
                    @endcan
                </form>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script type="text/javascript" src="{{asset('main/vendor/dropify/dist/js/dropify.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/assets/js/forms-upload.js')}}"></script>
    <script src="{{ url('asset/js/mask/jquery-mask-as-number.js') }}"></script>
    <script src="{{ url('asset/js/mask/jquery.mask.js') }}"></script>
    <script type="text/javascript">
        
        $('.cell_phone').mask('(00) 0 0000-0000');
        $('.phone').mask('(00) 0000-0000');
        $('.cpf').mask('000.000.000-00');

    </script>
    @endsection


