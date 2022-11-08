@extends('admin.layout.app')

@section('title', 'Atualizar Disputa ')

@section('content')

<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card m-b-20">

					<form class="form-horizontal" action="{{route('admin.dispute.update', $dispute->id )}}" method="POST" enctype="multipart/form-data" role="form">
						{{csrf_field()}}
						<input type="hidden" name="_method" value="PATCH">	
						<div class="card-body">				

							<div class="form-group row">
								<label for="dispute_type" class="col-sm-2 col-form-label">@lang('admin.dispute.dispute_type')</label>
								<div class="col-sm-10">
									<select name="dispute_type" class="form-control">
										<option value="user" @if($dispute->dispute_type=='user')selected @endif>Passageiro</option>
										<option value="provider" @if($dispute->dispute_type=='provider')selected @endif>Motorista</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label for="dispute_name" class="col-sm-2 col-form-label">@lang('admin.dispute.dispute_name')</label>
								<div class="col-sm-10">
									<input class="form-control" autocomplete="off"  type="text" value="{{ $dispute->dispute_name }}" name="dispute_name" required id="dispute_name" placeholder="@lang('admin.dispute.dispute_name')">
								</div>
							</div>

							<div class="form-group row">
								<label for="dispute_status" class="col-sm-2 col-form-label">@lang('admin.dispute.dispute_status')</label>
								<div class="col-sm-10">
									<select name="dispute_status" class="form-control">
										<option value="active" @if($dispute->status=='active')selected @endif>Ativo</option>
										<option value="inactive" @if($dispute->status=='inactive')selected @endif>Inativo</option>
									</select>
								</div>
							</div>
						</div>

						<div class="card-footer d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">@lang('admin.dispute.update_dispute')</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

@endsection
