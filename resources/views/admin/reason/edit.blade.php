@extends('admin.layout.app')

@section('title', 'Atualizar Motivo de Cancelamento ')

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
            <form class="form-horizontal" action="{{route('admin.reason.update', $reason->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">

            	 <div class="card-body">

				<div class="form-group row">
					<label for="type" class="col-sm-2 col-form-label">@lang('admin.reason.type')</label>
					<div class="col-sm-10">
						<select class="form-control" name="type" id="type">
							<option value="USER" @if($reason->type=='USER')selected @endif>PASSAGEIRO</option>
							<option value="PROVIDER" @if($reason->type=='PROVIDER')selected @endif>MOTORISTA</option>
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="reason" class="col-sm-2 col-form-label">@lang('admin.reason.reason')</label>
					<div class="col-sm-10">
						<input class="form-control" autocomplete="off"  type="text" value="{{ $reason->reason }}" name="reason" required id="reason" placeholder="@lang('admin.reason.reason')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="max_amount" class="col-sm-2 col-form-label">@lang('admin.reason.status')</label>
					<div class="col-sm-10">
						<select class="form-control" name="status" id="status">
							<option value="1" @if($reason->status==1)selected @endif>Ativo</option>
							<option value="0" @if($reason->status==0)selected @endif>Inativo</option>
						</select>
					</div>
				</div>


				
				</div>

                <div class="card-footer d-flex justify-content-end">
						<button type="submit" class="btn btn-primary">@lang('admin.reason.update_reason')</button>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection


