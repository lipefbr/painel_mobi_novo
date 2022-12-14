@extends('admin.layout.app')

@section('title', 'Atualizar Item Perdido ')

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

                        <form class="form-horizontal" action="{{route('admin.lostitem.update', $lostitem->id)}}" method="POST" enctype="multipart/form-data" role="form">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PATCH">

                            <div class="form-group row">
                                <label for="lost_item_name" class="col-sm-2 col-form-label">@lang('admin.lostitem.lost_item')</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="lost_item_name" required id="lost_item_name" placeholder="@lang('admin.lostitem.lost_item')">{{ $lostitem->lost_item_name }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comments" class="col-sm-2 col-form-label">@lang('admin.lostitem.lost_comments')</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="comments" required id="comments" placeholder="@lang('admin.lostitem.lost_comments')">{{ $lostitem->comments }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">@lang('admin.lostitem.lost_status')</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status" required id="status">
                                        <option @if($lostitem->status == 'open') required='required' @endif value="open">ABERTO</option>
                                        <option @if($lostitem->status == 'closed') required='required' @endif value="closed">FECHADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="comments_by" value="admin" />

                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">@lang('admin.lostitem.update')</button>

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