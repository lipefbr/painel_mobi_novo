@extends('admin.layout.app')

@section('styles')
<link href="{{ url('asset/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="{{ url('asset/js/tree/style.css') }}"  media="screen,projection"/>
@endsection

@if( is_null($role) )
@section('title', 'Criar Papel')
@else
@if(!is_null($disabled) )
@section('title', 'Ver Papel')
@else
@section('title', 'Editar Papel')
@endif
@endif

@section('content')

<div class="page-content-wrapper">
	<div class="container-fluid">

		<div class="row">
			<div class="col-sm-12">
				<div class="card m-b-20">
					<div class="card-body">

							@if( is_null($role) )
							{!! Form::open(['route' => ['admin.acl.role.store'], 'id' => 'papel-create', 'method' => 'post']) !!}
							@else
							{!! Form::model($role, ['route' => ['admin.acl.role.update', $role->id ], 'id' => 'papel-edit', 'method' => 'PUT']) !!}
							@endif
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Nome do papel</label>
								<div class="col-sm-5">
									{!! form::text('display_name', null, ['class' => 'form-control validate', 'placeholder' => 'Nome', 'disabled' => $disabled, 'required']) !!}
								</div>
								<div class="col-sm-5">
									{!! form::text('name', null, ['class' => 'form-control validate', 'placeholder' => 'Flag', 'disabled' => $disabled, 'required']) !!}
								</div>	
							</div>
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Permissões</label>

								<div class="col-sm-10">
									<br>
									@if (count($groups) > 0)
									
									<div id="permission-tree">
										<ul>
											@foreach ($groups as $group)
											<li>{!! $group->name !!}
												@if (count($group->permissions) > 0)
												<ul>
													@foreach ($group->permissions as $permission)
													<li id="{!! $permission->id !!}" >
														{!! $permission->display_name !!}
													</li>
													@endforeach
												</ul>
												@endif

												@if (count($group->children) > 0)
												<ul>
													@foreach ($group->children as $child)
													<li>{!! $child->name !!}
														@if (count($child->permissions) > 0)
														<ul> style="padding-left:40px;font-size:.8em">
															@foreach ($child->permissions as $permission_s)
															<li id="{!! $permission_s->id !!}" >
																{!! $permission_s->display_name !!}
															</li>
															@endforeach
														</ul>
														@endif
													</li>
													@endforeach
												</ul>
												@endif
											</li>
											@endforeach
										</ul>
									</div>
									@else
									<p>Nem uma permissão </p>
									@endif

								</div>
							</div>
						</div>



						 <div class="card-footer d-flex justify-content-end button-items">
									@if(is_null($role))	
										<button class="btn btn-primary " type="submit" name="action">CRIAR</button>
									@else
											

										@if(!is_null($disabled))
										@can('role-edit')
										<a class="btn waves-effect waves-light" href="{{ route('admin.acl.role.edit' , $role->id) }}">EDITAR</a>
										@endcan
										@else
										@can('role-delete')
										<button href="{{ route('admin.acl.role.destroy' , [$role->id] )  }}" data-method="delete" data-long-text="{{ $role->name }}"  class="btn btn-danger" data-title="Deseja realmente excluir permanentimente esse papel?" type="button">EXCLUIR</button>
										@endcan

										<button class="btn btn-primary" type="submit" name="action">ATUALIZAR</button>
										@endif

									@endif

						</div>
						{!! Form::hidden('permissions', null, ['autocomplete' => "off"]) !!}

						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('asset/js/tree/jstree.js') }}"></script>
<script src="{{ url('asset/js/sweetalert2/sweetalert2.js') }}"></script>

<script type="text/javascript">
//var associated = $("select[name='associated-permissions']");
//var associated_container = $("#available-permissions");
var tree = $('#permission-tree');


/**
* Initiate the tree and open all items
* When a node is changed, loop through all of its dependencies
* and search through the tree to check/uncheck them
*/
var check_dependencies = false;
tree.jstree({   
	"checkbox" : {
		"keep_selected_style" : true
	}, 
// "state" : { "disable" : 'disabled' },
"plugins" : ["checkbox"],
}).on('ready.jstree', function(event, object) {
	tree.jstree('hide_icons');
	$('[data-toggle="tooltip"]').tooltip();

	@if($disabled)
	tree.jstree('open_all');
	object.instance.bind("uncheck_node.jstree",function(e,data){
		return false;
	});    	
	@else 
	tree.jstree('close_all');
	@endif    

}).on('ready.jstree', function() {
	check_dependencies = true;
}).on('changed.jstree', function (event, object) {
//Check all dependency nodes and disable
if (check_dependencies) {
	if (!!object.node) {
		if (!!object.node.data.dependencies) {
			if (object.node.data.dependencies.length) {
				var checked = tree.jstree('is_checked', object.node);

				for (var i = 0; i < object.node.data.dependencies.length; i++) {
					if (checked) {
						tree.jstree('check_node', object.node.data.dependencies[i]);
						checkUngrouped(object.node.data.dependencies[i]);
					}
				}
			}
		}
	}
}
});

/**
* When an ungrouped permission is checked
* filter through its dependencies and check them
*/
$("input[name='ungrouped[]']").change(function() {
	var dependencies = $(this).data('dependencies');
	if (dependencies.length)
		for (var i = 0; i < dependencies.length; i++)
			if ($(this).is(":checked"))
				tree.jstree('check_node', dependencies[i]);
		});

/**
* Check all dependent permissions in the ungrouped section based on
* the id of another permission
* @param id
*/
function checkUngrouped(id) {
//Check nodes from the ungrouped column
$("input[name='ungrouped[]']").each(function() {
	if (parseInt($(this).val()) == id)
		$(this).attr('checked', true);
});
}

/**
* Get list of the checked items and send them to the serer
*/
$("#papel-create, #papel-edit").submit(function() {
	var checked_ids = tree.jstree("get_checked", false);
	$("input[name='ungrouped[]']").each(function () {
		if( !isNaN( $(this).val() ) )
			checked_ids.push($(this).val());

		console.log( checked_ids );
	});
	$("input[name='permissions']").val(checked_ids);
});

@if(! is_null($role) )
@foreach($role->permissions as $permission)
tree.jstree('check_node', '#{!! $permission->id !!}');
@endforeach
@endif

</script>

@endsection