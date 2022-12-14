@extends('admin.layout.app')

@section('title', 'Notificação Push ')

@section('styles')
<link href="{{asset('asset/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{asset('asset/css/bootstrap-timepicker.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">


                <div class="card m-b-20">
                    

            <form class="form-horizontal" action="{{route('admin.send.push')}}" method="POST" role="form" id="create_push">

                {{csrf_field()}}

                <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">@lang('admin.push.Sent_to')</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="send_to" onchange="switch_send(this.value)">

                            @can('custom-push-user', 'custom-push-driver')
                            <option value="ALL">Todos Passageiros e Motoristas</option>
                            @endcan
                            @can('custom-push-user')
                            <option value="USERS">Todos Passageiros</option>
                            @endcan
                            @can('custom-push-driver')
                            <option value="PROVIDERS">Todos Motoristas</option>
                            @endcan
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="for_users" style="display: none;">
                    <label class="col-sm-2 col-form-label">Condições do Passageiro</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="user_condition" onchange="switch_user_condition(this.value);">
                            <option value="">Nenhuma</option>
                            <option value="ACTIVE">Para passageiros ativos em </option>
                            <option value="LOCATION">Usuários que estão em </option>
                            <option value="RIDES">Quem usou o serviço mais de </option>
                            <!-- <option value="AMOUNT"> who spent more than </option> -->
                        </select>
                    </div>
                    <div class="col-sm-5" id="user_active" style="display: none;">
                        <select class="form-control" name="user_active">
                            <option value="HOUR">Última uma hora</option>
                            <option value="WEEK">Última semana </option>
                            <option value="MONTH">Último mês </option>
                        </select>
                    </div>

                    <div class="col-sm-5" id="user_rides"  style="display: none;">
                        <input type="number" class="form-control" name="user_rides" placeholder="Número de Viagens">
                    </div>

                    <div class="col-sm-5" id="user_amount" style="display: none;">
                        <input type="number" class="form-control" name="user_amount" placeholder="Valor Gasto">
                    </div>

                    <div class="col-sm-5" id="user_location" style="display: none;">
                        <input type="text" class="form-control"  id="search_location" placeholder="Digite a Localização">
                        <input type="hidden" name="user_location" id="user_point">
                    </div>

                </div>


                <div class="form-group row" id="for_providers" style="display: none;">
                    <label class="col-sm-2 col-form-label">Condição dos Motoristas</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="provider_condition" onchange="switch_provider_condition(this.value);">
                            <option value="">Nenhuma</option>
                            <option value="ACTIVE">Para motoristas ativos em </option>
                            <option value="LOCATION">Motoristas que estão em </option>
                            <option value="RIDES">Quem atendeu mais de </option>
                            <!-- <option value="AMOUNT">  who earned more than </option> -->
                        </select>
                    </div>
                    <div class="col-sm-5" id="provider_active" style="display: none;">
                        <select class="form-control" name="provider_active">
                            <option value="HOUR">Última uma hora</option>
                            <option value="WEEK">Última semana </option>
                            <option value="MONTH">Último mês </option>
                        </select>
                    </div>

                    <div class="col-sm-5" id="provider_rides"  style="display: none;">
                        <input type="number" class="form-control" name="provider_rides" placeholder="Número de Viagens">
                    </div>

                    <div class="col-sm-5" id="provider_amount" style="display: none;">
                        <input type="number" class="form-control" name="provider_amount" placeholder="Valor Gasto">
                    </div>

                    <div class="col-sm-5" id="provider_location" style="display: none;">
                        <input type="text" class="form-control" id="search_provider_location" placeholder="Digite a Localização">
                        <input type="hidden" name="provider_location" id="provider_point">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="message" class="col-sm-2 col-form-label">@lang('admin.push.message')</label>
                    <div class="col-sm-10">
                        <textarea maxlength="200" class="form-control" rows="3" name="message" required id="message" placeholder="Digite a Mensagem" ></textarea>
                        <div id="characterLeftDesc"></div>
                    </div>
                </div>

                </div>

                <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">@lang('admin.push.Push_Now')</button>
                        <!--
                        <button data-toggle="modal" data-target="#schedule_modal" type="button" class="btn btn-success">@lang('admin.push.Schedule_Push')</button>
                        -->
                </div>
            </form>
 
        </div>

        @can('notification-push-list')
        <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
            <div class="table-responsive order-table">
                            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>@lang('admin.push.Sent_to')</th>
                        <th>@lang('admin.message')</th>
                        <th>@lang('admin.push.Condition')</th>
                        <th>@lang('admin.push.Sent_on')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Pushes as $index => $Push)
                    <tr>
                        <td>{{ $Push->send_to }}</td>
                        <td>{{ $Push->message }}</td>
                        <td>{{ $Push->condition }}</td>
                        <td>
                            @if($Push->created_at)
                            <span class="text-muted">{{$Push->created_at->diffForHumans()}}</span>
                            @else
                            -
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
        @endcan

    </div>
</div>
</div>
</div>



<!-- Schedule Modal -->
<div id="schedule_modal" class="modal fade bs-modal-confirm schedule-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Programar Envio de Notificação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form>
                <div class="modal-body">

                    <label>Data</label>
                    <input value="{{date('m/d/Y')}}" class="form-control" type="text" id="datepicker" placeholder="Data" name="schedule_date">
                    <label>Hora</label>
                    <input value="{{date('H:i')}}" class="form-control" type="text" id="timepicker" placeholder="Hora" name="schedule_time">

                </div>
                <div class="modal-footer">
                    <button type="button" id="schedule_button" class="btn btn-primary" data-dismiss="modal">Agendar</button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')

<script src="{{asset('asset/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap-timepicker.js')}}"></script>

<script type="text/javascript">
    @if (Setting::get('demo_mode', 0) == 1)
    $("#create_push :input").prop("disabled", true);
    @endif

            $('#characterLeftDesc').text('100 caracteres restantes');

    $('#message').keyup(function () {
        var max = 100;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeftDesc').text(' You have reached the limit');
        } else {
            var ch = max - len;
            $('#characterLeftDesc').text(ch + ' caracteres restantes');
        }
    });
</script>

<script type="text/javascript">
    function switch_send(send_value) {
        if (send_value == 'USERS') {
            $('#for_users').show();
            $('#for_providers').hide();
        } else if (send_value == 'PROVIDERS') {
            $('#for_users').hide();
            $('#for_providers').show();
        } else {
            $('#for_users').hide();
            $('#for_providers').hide();
        }
    }


    function switch_user_condition(condition_value) {
        if (condition_value == 'ACTIVE') {
            $('#user_active').show();
            $('#user_location').hide();
            $('#user_amount').hide();
            $('#user_rides').hide();
        } else if (condition_value == 'LOCATION') {
            $('#user_active').hide();
            $('#user_location').show();
            $('#user_amount').hide();
            $('#user_rides').hide();
        } else if (condition_value == 'AMOUNT') {
            $('#user_active').hide();
            $('#user_location').hide();
            $('#user_amount').show();
            $('#user_rides').hide();
        } else if (condition_value == 'RIDES') {
            $('#user_active').hide();
            $('#user_location').hide();
            $('#user_amount').hide();
            $('#user_rides').show();
        } else {
            $('#user_active').hide();
            $('#user_location').hide();
            $('#user_amount').hide();
            $('#user_rides').hide();
        }
    }


    function switch_provider_condition(condition_value) {
        if (condition_value == 'ACTIVE') {
            $('#provider_active').show();
            $('#provider_location').hide();
            $('#provider_amount').hide();
            $('#provider_rides').hide();
        } else if (condition_value == 'LOCATION') {
            $('#provider_active').hide();
            $('#provider_location').show();
            $('#provider_amount').hide();
            $('#provider_rides').hide();
        } else if (condition_value == 'AMOUNT') {
            $('#provider_active').hide();
            $('#provider_location').hide();
            $('#provider_amount').show();
            $('#provider_rides').hide();
        } else if (condition_value == 'RIDES') {
            $('#provider_active').hide();
            $('#provider_location').hide();
            $('#provider_amount').hide();
            $('#provider_rides').show();
        } else {
            $('#provider_active').hide();
            $('#provider_location').hide();
            $('#provider_amount').hide();
            $('#provider_rides').hide();
        }
    }

</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#schedule_button').click(function () {
            $("#datepicker").clone().attr('type', 'hidden').appendTo($('#create_push'));
            $("#timepicker").clone().attr('type', 'hidden').appendTo($('#create_push'));
            document.getElementById('create_push').submit();
        });
    });
</script>
<script type="text/javascript">
    var date = new Date();
    date.setDate(date.getDate() - 1);
    $('#datepicker').datepicker({
        startDate: date
    });
    $('#timepicker').timepicker({showMeridian: false});
</script>


<script>

    var autocomplete, autocompleteprovider;

    function initAutocomplete() {

        autocomplete = new google.maps.places.Autocomplete(document.getElementById('search_location'));
        autocompleteprovider = new google.maps.places.Autocomplete(document.getElementById('search_provider_location'));

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace().geometry.location;
            set_location(place.lat(), place.lng());
        });

        autocompleteprovider.addListener('place_changed', function () {
            var providerplace = autocompleteprovider.getPlace().geometry.location;
            set_provider_location(providerplace.lat(), providerplace.lng());
        });

    }

    function set_location(lat, lng) {
        document.getElementById('user_point').value = lat + ',' + lng;
    }

    function set_provider_location(lat, lng) {
        document.getElementById('provider_point').value = lat + ',' + lng;
    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{Config::get('constants.map_key')}}&libraries=places&callback=initAutocomplete"
async defer></script>
@endsection