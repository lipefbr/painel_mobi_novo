@extends('admin.layout.app')

@section('title', 'Adicionar Item Perdido ')

@section('content')
<style>
    .input-group{
        width: none;
    }
    .input-group .fa-search{
        display: table-cell;
    }
</style>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                    <div class="card-body">


            <form class="form-horizontal" action="{{route('admin.lostitem.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}

                <div class="form-group row">
                    <label for="user" class="col-sm-2 col-form-label">@lang('admin.lostitem.lost_user')</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="namesearch" placeholder="Pesquisar Nome" required="" aria-describedby="basic-addon2" autocomplete="off">
                            
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="">
                    </div>
                </div>				

                <div class="form-group row">
                    <label for="lost_item_name" class="col-sm-2 col-form-label">@lang('admin.lostitem.request')</label>
                    <div class="col-sm-10">
                        <table class="table table-striped table-bordered dataTable requestList">
                            <thead>
                                <tr>
                                    <th>ID Viagem</th>
                                    <th>De</th>
                                    <th>Para</th>                           
                                    <th>Selecionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="4">Sem resultados</td></tr>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lost_item_name" class="col-sm-2 col-form-label">@lang('admin.lostitem.lost_item')</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="lost_item_name" required id="lost_item_name" placeholder="@lang('admin.lostitem.lost_item')">{{ old('lost_item') }}</textarea>
                    </div>
                </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">@lang('admin.lostitem.add')</button>
                </div>

            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
<link href="{{ asset('asset/css/jquery-ui.css') }}" rel="stylesheet"> 
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('asset/js/jquery-ui.js') }}"></script>

<script type="text/javascript">
var sflag = '';
$('#namesearch').autocomplete({
    source: function (request, response) {
        $.ajax
            ({
                type: "GET",
                url: '{{ route("admin.usersearch") }}',
                data: {stext: request.term},
                dataType: "json",
                success: function (responsedata, status, xhr)
                {
                    if (!responsedata.data.length) {
                        var data = [];
                        data.push({
                            id: 0,
                            label: "@lang('No Records')"
                        });
                        response(data);
                    } else {
                        response($.map(responsedata.data, function (item) {
                            var name_alias = item.first_name + " - " + item.id;
                            $('#user_id').val(item.id);
                            return {
                                value: name_alias,
                                id: item.id,
                                bal: item.wallet_balance
                            }
                        }));
                    }
                }
            });
    },
    minLength: 2,
    change: function (event, ui)
    {
        if (ui.item == null) {
            $("#namesearch").val('');
            $("#namesearch").focus();
            $("#wallet_balance").text("-");
        } else {
            if (ui.item.id == 0) {
                $("#namesearch").val('');
                $("#namesearch").focus();
                $("#wallet_balance").text("-");
            }
        }
    },
    select: function (event, ui) {

        $.ajax({
            url: "{{ route('admin.ridesearch') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                id: ui.item.id
            },
            success: function (data, textStatus, jqXHR) {
                var requestList = $('.requestList tbody');
                requestList.html(`<tr><td colspan="4">@lang('No Records')</td></tr>`);
                if (data.data.length > 0) {
                    var result = data.data;
                    for (var i in result) {
                        requestList.html(`<tr><td>` + result[i].booking_id + `</td><td>` + result[i].s_address + `</td><td>` + result[i].d_address + `</td><td><input name="request_id" value="` + result[i].id + `" type="radio" /></td></tr>`);
                    }
                } else {
                    requestList.html(`<tr><td colspan="4">No Results</td></tr>`);
                }
            }
        });

        $("#from_id").val(ui.item.id);
        $("#wallet_balance").text(ui.item.bal);
    }
});

</script>    
@endsection