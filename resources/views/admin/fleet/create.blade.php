@extends('admin.layout.app')

@section('title', 'Nova Franquia ')

@section('styles')

<link href="{{ url('agroxa/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('content')


<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                    <form class="form-horizontal" action="{{route('admin.fleet.store')}}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{csrf_field()}}

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-10">
                                <select name="" class="form-control select2" id="states" required>
                                    <option value="">Selecione o Estado</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}"{{ !is_null($stateId) && $state->id == $stateId->id?' selected':'' }}>{{ $state->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Cidade</label>
                            <div class="col-sm-10">
                                <select name="city_id" class="form-control select2" id="cities" required>
                                    <option value="">Selecione a cidade</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                            class="col-sm-2 col-form-label">Nome da Franquia</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="{{ old('name') }}" name="name" required
                                id="name" placeholder="Nome da Franquia">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company" class="col-sm-2 col-form-label">Representante</label>
                            <div class="col-sm-10">

                                <select name="admin_id" class="form-control select2" id="admin_id" required>
                                    <option value="">Selecione o Gerente</option>
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }} - {{ $admin->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label for="logo" class="col-sm-2 col-form-label">@lang('admin.fleet.company_logo')</label>
                            <div class="col-sm-10">
                                <input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo"
                                aria-describedby="fileHelp">
                            </div>
                        </div>

                      

                        <div class="form-group row">
                            <label for="commission"
                            class="col-sm-2 col-form-label">@lang('admin.fleet.fleet_commission')</label>
                            <div class="col-sm-10">
                                <input class="form-control asNumber" type="number" value="{{ old('commission') }}" name="commission"
                                id="commission" placeholder="Comissão">

                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">@lang('admin.auth.sign_in')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    @endsection

    @section('scripts')

    <script type="text/javascript" src="{{asset('main/vendor/dropify/dist/js/dropify.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/assets/js/forms-upload.js')}}"></script>
    <script src="{{ url('asset/js/mask/jquery-mask-as-number.js') }}"></script>
    <script src="{{ url('agroxa/plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(".select2").select2();
        //$('.asNumber').maskAsNumber();

        $('#states').change(function () {
            var idEstado = $(this).val();
            $.get('/admin/cities/' + idEstado, function (cidades) {
                $('#cities').empty();
                $.each(cidades, function (key, value) {
                    $('#cities').append('<option value=' + value.id + '>' + value.title + '</option>');
                });console.log(cidades);
            });
        });
    </script>
    @endsection
