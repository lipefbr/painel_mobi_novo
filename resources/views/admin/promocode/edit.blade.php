@extends('admin.layout.app')

@section('title', 'Atualizar Cupom Promocional ')


@section('styles')
<link href="{{ url('agroxa/plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<!--
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap-datetimepicker.min.css')}}">
-->
@endsection

@section('content')
  
<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                <form class="form-horizontal" action="{{route('admin.promocode.update', $promocode->id )}}"
                      method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">

                     <div class="card-body">

                    <div class="form-group row">
                        <label for="promo_code" class="col-sm-2 col-form-label">Franquia</label>
                        <div class="col-sm-10">
                            <select name="fleet_id" class="form-control" required>
                                <option value="">Selecione a franquia</option>
                                @foreach($fleets as $fleet)
                                    <option value="{{ $fleet->id }}"{{ !empty($promocode->fleet_id) && $fleet->id==$promocode->fleet_id?'selected':'' }}>{{ $fleet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="promo_code"
                               class="col-sm-2 col-form-label">@lang('admin.promocode.promocode')</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="{{ $promocode->promo_code }}"
                                   name="promo_code" required id="promo_code"
                                   placeholder="@lang('admin.promocode.promocode')">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="percentage"
                               class="col-sm-2 col-form-label">@lang('admin.promocode.percentage')</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" value="{{ $promocode->percentage }}"
                                   name="percentage" required id="percentage"
                                   placeholder="@lang('admin.promocode.percentage')">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="max_amount"
                               class="col-sm-2 col-form-label">@lang('admin.promocode.max_amount')</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="max_amount" required id="max_amount"
                                   placeholder="@lang('admin.promocode.max_amount')" value="{{$promocode->max_amount}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="expiration"
                               class="col-sm-2 col-form-label">@lang('admin.promocode.expiration')</label>
                        <div class="col-sm-10">
                            <input class="form-control datetimepicker" type="text" value="{{ $promocode->expiration }}"
                                   name="expiration" required id="expiration"
                                   placeholder="@lang('admin.promocode.expiration')">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="promo_description"
                               class="col-sm-2 col-form-label">@lang('admin.promocode.promo_description')</label>
                        <div class="col-sm-10">
                            <textarea id="promo_description" placeholder="Description" class="form-control"
                                      name="promo_description">{{ $promocode->promo_description }}</textarea>
                        </div>
                    </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                            <button type="submit"
                                    class="btn btn-primary">@lang('admin.promocode.update_promocode')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

@endsection
@section('scripts')
  <script src="{{ url('agroxa/plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js') }}"></script>

<script src="{{ url('agroxa/plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <script type="text/javascript">
$(document).ready(function () {
    $(function () {
        $('.datetimepicker').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', minDate : new Date() });

        //$('.datetimepicker').datetimepicker({minDate: moment(), format: 'YYYY-MM-DD HH:mm'});
    });
});

$("#percentage").on('keyup', function () {
    var per = $(this).val() || 0;
    var max = $("#max_amount").val() || 0;
    $("#promo_description").val(per + '% off! Valor máximo de desconto R$' + max);
});

$("#max_amount").on('keyup', function () {
    var max = $(this).val() || 0;
    var per = $("#percentage").val() || 0;
    $("#promo_description").val(per + '% off! Valor máximo de desconto R$' + max);
});

</script>
@endsection

