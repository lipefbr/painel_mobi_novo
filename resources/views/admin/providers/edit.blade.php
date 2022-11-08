@extends('admin.layout.app')

@section('title', 'Editar Motorista ')
@section('styles')
<link rel="stylesheet" href="{{asset('asset/css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
<link href="{{ url('agroxa/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')


<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="card m-b-20">

            <form class="form-horizontal" action="{{route('admin.provider.update', $provider->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">

                 <div class="card-body">

                @if(!is_null($fleets))
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Franquia</label>  
                    <div class="col-sm-10">
                      {!! Form::select('fleet_id', $fleets , is_object($provider) ? $provider->fleet : 0, [ 'style' => 'width: 100%;', 'disabled' => $disabled, 'required', 'class' => 'select2 form-control', 'data-placeholder' => "Vincular franquia"]) !!}
                    </div>
                </div>
                @endif

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
                        <input class="form-control" type="text" value="{{ $provider->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
                    </div>

                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ $provider->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="cpf" class="col-sm-2 col-form-label">CPF/Senha</label>
                    <div class="col-sm-4">
                        <input class="form-control cpf" type="text" value="{{ $provider->cpf }}" name="cpf" required id="cpf" placeholder="CPF">
                    </div>

                    <!--
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ $provider->cnh }}" name="cnh" required id="cnh" placeholder="CNH">
                    </div>

                    <label class="col-sm-2 col-form-label">@lang('admin.password')</label>
                    -->

                    <div class="col-sm-3">
                        <input type="password" class="form-control" name="password" placeholder="@lang('admin.password')">
                    </div>
          
                    <div class="col-sm-3">
                        <input type="password" class="form-control" name="password_confirm" placeholder="@lang('admin.account-manager.password_confirmation')">
                    </div>
                </div>

                <div class="form-group row">
                    
                    <label for="picture" class="col-sm-2 col-form-label">@lang('admin.picture')</label>
                    <div class="col-sm-10">
                    @if(isset($provider->avatar))
                        <img style="margin-bottom: 15px;" class="thumb-md rounded-circle mr-2" src="{{img($provider->avatar)}}">
                    @endif
                        <input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>
                <!--
                <div class="form-group row">
                    <label for="country_code" class="col-sm-2 col-form-label">Código do País</label>
                    <div class="col-sm-10">
                    <input type="text" name="country_code" style ="padding-bottom:5px;" id="country_code" class="country-name"  value="{{ $provider->country_code}}" >
                    </div>
                </div>
                -->
                <div class="form-group row">
                    <label for="mobile" class="col-sm-2 col-form-label">@lang('admin.mobile')</label>
                    <div class="col-sm-10">
                        <input class="form-control cell_phone" type="text" value="{{ $provider->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
                    </div>
                </div>

                 <div class="form-group row">
                    <div class="col-sm-2 arabic_right">
                          <label for="debit-machine-payments" class="col-form-label">
                              Tem maquina de debito
                          </label>
                      </div>
                      <div class="col-sm-10">

                          <input name="debit_machine" type="checkbox" class="js-switch" data-color="#43b968" id="debit-machine-payments" switch="none" @if($provider->debit_machine == 1) checked  @endif  />
                          <label for="debit-machine-payments" style="margin-top: 8px" data-on-label="SIM"
                          data-off-label="NÃO"></label>
                      </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 arabic_right">
                          <label for="debit-machine-payments" class="col-form-label">
                              Dono da maquina
                          </label>
                      </div>
                      <div class="col-sm-10">

                          <input name="debit_machine_fleet" type="checkbox" class="js-switch" data-color="#43b968" id="debit-machine-payments-fleet" switch="none" @if($provider->debit_machine_fleet == 1) checked  @endif   />
                          <label for="debit-machine-payments-fleet" style="margin-top: 8px" data-on-label="FRAN"
                          data-off-label="MOT"></label>
                      </div>
                </div>

                
                

               </div>


                <div class="card-footer d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">@lang('admin.provides.update_provider')</button>
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
       var providerCity = "{{ $provider->city_id }}";

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
                   if(value.id == providerCity){
                       $('#cities').append('<option value=' + value.id + ' selected>' + value.title + '</option>');
                   }else{
                       $('#cities').append('<option value=' + value.id + '>' + value.title + '</option>');
                   }
               });
           });
       }

       window.intlTelInput(input,({
           // separateDialCode:true,
       }));
       $(".country-name").click(function(){
           var myVar = $(this).closest('.country').find(".dial-code").text();
           //$('#country_code').val(myVar);
        });
		</script>
@endsection