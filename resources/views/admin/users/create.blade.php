@extends('admin.layout.app')

@section('title', 'Adicionar Passageiro ')
@section('styles')
<link rel="stylesheet" href="{{asset('asset/css/intlTelInput.css')}}">

<link href="{{ url('agroxa/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('content')

<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="card m-b-20">

          <form class="form-horizontal" action="{{route('admin.user.store')}}" method="POST" autocomplete="false" enctype="multipart/form-data" role="form">
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
                <label for="first_name" class="col-sm-2 col-form-label">@lang('admin.first_name') / @lang('admin.last_name')</label>
                <div class="col-sm-5">
                  <input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="@lang('admin.first_name')">
                </div>

                <div class="col-sm-5">
                  <input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="@lang('admin.last_name')">
                </div>
              </div>

              <div class="form-group row">
                <label for="last_name" class="col-sm-2 col-form-label">CPF</label>
                <div class="col-sm-10">
                  <input class="form-control cpf" type="text" value="{{ old('cpf') }}" name="cpf" required id="cpf" placeholder="CPF">
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">@lang('admin.email')</label>
                <div class="col-sm-10">
                  <input class="form-control" type="email" autocomplete="false" required name="email" value="{{old('email')}}" id="email" placeholder="@lang('admin.email')">
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">@lang('admin.password') / @lang('admin.provides.password_confirmation')</label>
                <div class="col-sm-5">
                  <input class="form-control" type="password" autocomplete="false" name="password" id="password" placeholder="@lang('admin.password')">
                </div>

                <div class="col-sm-5">
                  <input class="form-control" autocomplete="false" type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('admin.provides.password_confirmation')">
                </div>
              </div>

              <div class="form-group row">
                <label for="picture" class="col-sm-2 col-form-label">@lang('admin.picture')</label>
                <div class="col-sm-10">
                  <input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                </div>
              </div>

              <div class="form-group row">
                <label for="country_code" class="col-sm-2 col-form-label">@lang('admin.mobile')</label>

                  <input type="hidden" name="country_code" value="+55" style ="padding-right:  26px; display: none" class="form-control"  >

                <div class="col-sm-10">
                  <input class="form-control cell_phone" autocomplete="off" type="text" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="@lang('admin.mobile')">
                </div>
              </div>

            </div>


            <div class="card-footer d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Cadastrar Novo Passageiro</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('asset/js/intlTelInput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/js/intlTelInput-jquery.min.js') }}"></script>

<script type="text/javascript" src="{{asset('main/vendor/dropify/dist/js/dropify.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/assets/js/forms-upload.js')}}"></script>

<script src="{{ url('agroxa/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ url('asset/js/mask/jquery.mask.js') }}"></script>
<script type="text/javascript">

  $(".select2").select2();

  $('.cpf').mask('000.000.000-00');

  $('.cell_phone').mask('(00) 0 0000-0000');
  
  var input = document.querySelector("#country_code");

  var states = $('#states');

  states.change(function () {
    var idEstado = $(this).val();
    $.get('/admin/cities/' + idEstado, function (cidades) {
      $('#cities').empty();
      $.each(cidades, function (key, value) {
        $('#cities').append('<option value=' + value.id + '>' + value.title + '</option>');
      });
    });
  });

  if(states.val() != null){
    $.get('/admin/cities/' + states.val(), function (cidades) {
      $('#cities').empty();
      $.each(cidades, function (key, value) {
        $('#cities').append('<option value=' + value.id + '>' + value.title + '</option>');
      });
    });
  }

  window.intlTelInput(input,({
// separateDialCode:true,
}));
  /*
  $(".country-name").click(function(){
    var myVar = $(this).closest('.country').find(".dial-code").text();
    $('#country_code').val(myVar);
  });
  */
</script>
@endsection