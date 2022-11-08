@extends('admin.layout.app')

@section('title', 'Adicionar Disputa')

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">


                    <form class="form-horizontal" action="{{route('admin.dispute.store')}}" method="POST" enctype="multipart/form-data" role="form">
                        {{csrf_field()}}            
                        <div class="card-body">	

                            <div class="form-group row">
                                <label for="dispute_type" class="col-sm-2 col-form-label">@lang('admin.dispute.dispute_type')</label>
                                <div class="col-sm-10">
                                    <select name="dispute_type" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="user">Passageiro</option>
                                        <option value="provider">Motorista</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dispute_name" class="col-sm-2 col-form-label">@lang('admin.dispute.dispute_name')</label>
                                <div class="col-sm-10">
                                    <input class="form-control" autocomplete="off"  type="text" value="{{ old('dispute_name') }}" name="dispute_name" required id="dispute_name" placeholder="@lang('admin.dispute.dispute_name')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dispute_status" class="col-sm-2 col-form-label">@lang('admin.dispute.dispute_status')</label>
                                <div class="col-sm-10">
                                    <select name="dispute_status" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="active">Ativo</option>
                                        <option value="inactive">Inativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">@lang('admin.dispute.add_dispute')</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
