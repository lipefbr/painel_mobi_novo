@extends('admin.layout.app')

@section('title', 'Adicionar Documento')

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">

                    <form class="form-horizontal" action="{{route('admin.document.store')}}" method="POST" enctype="multipart/form-data" role="form">
                        {{csrf_field()}}

                        
                        @if( request()->get('fleet') )
                            <input  type="hidden" value="{{ Request::get('fleet') }}" name="fleet_id" />
                        @endif

                        <div class="card-body">

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">@lang('admin.document.document_name')</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Nome do @lang('admin.document.document_name')">
                                </div>

                                <label for="name" class="col-sm-2 col-form-label">@lang('admin.document.document_type')</label>
                                <div class="col-sm-4">
                                    <select name="type" class="form-control">
                                        <option value="DRIVER">@lang('admin.document.driver_review')</option>
                                        <option value="VEHICLE">@lang('admin.document.vehicle_review')</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">@lang('admin.document.add_Document')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
