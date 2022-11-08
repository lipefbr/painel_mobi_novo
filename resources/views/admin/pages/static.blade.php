@extends('admin.layout.app')

@section('title', 'Páginas ')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">



            <div class="col-sm-12">
                <div class="card">
                    

                <form id="cmspages" action="{{ route('admin.pages.update') }}" method="POST">
                    <div class="card-body">
                
                    <div class="form-group">
                        <select class="form-control" id="types" name="types">
                            <option value="select">Selecione</option>
                            <option value="help">Ajuda</option>
                            <option value="page_privacy">Política de Privacidade</option>
                            <option value="terms">Termos de Uso</option>
                            <option value="cancel">Política de Cancelamento</option>
                        </select>
                    </div>
                    {{ csrf_field() }}                    

                    <div class="row">
                        <div class="col-sm-12">
                            <textarea name="content" class="content" id="myeditor"></textarea>
                        </div>
                    </div>
                    </div>
                    @can('cms-pages-update')
                     <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('myeditor');</script>
<script type="text/javascript">
    @if (Setting::get('demo_mode', 0) == 1)
    $("#cmspages :input").prop("disabled", true);
    $("#types").prop("disabled", false);
    @endif

            $(document).ready(function(){
    $("#types").change(function(){
    var types = $("#types").val();
            $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_toke-n"]').attr('content') }
            });
            $.ajax({url: "{{ url('admin/pages/search') }}/" + types,
                    success: function(data) {
                    // $('#doc_title').val("");
                    //alert(data);
                    CKEDITOR.instances["myeditor"].setData(data)
                            //$('#myeditor').val("data");
                            //document.getElementById("myeditor").value = "blah ... "
                            //$(".content").val(data);
                            //$("#myeditor").hide();
                            //$("#myeditor").hide();
                            // $("#myeditor").append("<textarea id='myeditor'   name='content' >"+data+"</textarea> </br> ");
                    }});
    });
    }
    );
</script>

@endsection