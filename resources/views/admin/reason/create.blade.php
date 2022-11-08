@extends('admin.layout.app')

@section('title', 'Novo Motivo de Cancelamento ')

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

            <form class="form-horizontal" action="{{route('admin.reason.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}

                 <div class="card-body">

                <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">@lang('admin.reason.type')</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="type" id="type">
                            <option value="">Selecione</option>
                            <option value="USER">Passageiro</option>
                            <option value="PROVIDER">Motorista</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="reason" class="col-sm-2 col-form-label">@lang('admin.reason.reason')</label>
                    <div class="col-sm-10">
                        <input class="form-control" autocomplete="off"  type="text" value="{{ old('reason') }}" name="reason" required id="reason" placeholder="@lang('admin.reason.reason')">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="max_amount" class="col-sm-2 col-form-label">@lang('admin.reason.status')</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status" id="status">
                            <option value="">Selecione</option>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>

               
                </div>

                <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">@lang('admin.reason.add_reason')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

