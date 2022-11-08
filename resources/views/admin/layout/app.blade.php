<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>@yield('title') | {{ setting('site_title', config('constants.site_title', 'Mobub')) }}</title>
    
    
    
    @yield('styles')
    <link href="{{ url('agroxa/horizontal-green/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('agroxa/horizontal-green/assets/css/icons.css') }}" rel="stylesheet" type="text/css">


    @switch(setting('menu_skin', 'skin-2') )
        @case('skin-1')
            <!-- Roxo -->
            <link href="{{ url('agroxa/horizontal-green/assets/css/style_purple.css') }}" rel="stylesheet" type="text/css">
        @break

        @case('skin-2')
            <!-- Preto -->
            <link href="{{ url('agroxa/horizontal-green/assets/css/style_dark.css') }}" rel="stylesheet" type="text/css">
        @break

        @case('skin-3')
            <!-- Brnaco e Cinza-->
            <link href="{{ url('agroxa/horizontal-green/assets/css/style_white.css') }}" rel="stylesheet" type="text/css">
        @break

        @case('skin-5')
            <!-- Verde -->
            <link href="{{ url('agroxa/horizontal-green/assets/css/style.css') }}" rel="stylesheet" type="text/css">
        @break


        @case('skin-6')
            <!-- Vermelho -->
            <link href="{{ url('agroxa/horizontal-green/assets/css/style_red.css') }}" rel="stylesheet" type="text/css">
        @break

        @case('skin-7')
            <!-- Azul -->
            <link href="{{ url('agroxa/horizontal-green/assets/css/style_blue.css') }}" rel="stylesheet" type="text/css">
        @break

        @default
             <link href="{{ url('agroxa/horizontal-green/assets/css/style_dark.css') }}" rel="stylesheet" type="text/css">
    @endswitch



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <meta name="_token" content="{{ csrf_token() }}">


    <style type="text/css">
        .toast {
            /*top: 53px;*/
        }
    </style>

</head>
<body>
    @include('admin.layout.partials.header')

    <div class="wrapper">

        <div class="page-title-box">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-sm-12"> 
                        <h4 class="page-title">@yield('title', 'Painel')</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">@yield('subtitle', '')</li>
                        </ol>

                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    
    @include('admin.layout.partials.footer')

    <!-- JavaScripts -->
    
    <!-- jQuery  -->
    <script src="{{ url('agroxa/horizontal-green/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('agroxa/horizontal-green/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('agroxa/horizontal-green/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ url('agroxa/horizontal-green/assets/js/waves.min.js') }}"></script>

    <script src="{{ url('agroxa//plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Peity JS -->
    <script src="{{ url('agroxa/plugins/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ url('agroxa/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ url('agroxa/plugins/raphael/raphael-min.js') }}"></script>

    <!--
    <script src="{{ url('agroxa/horizontal-green/assets/pages/dashboard.js') }}"></script>   
    -->     

    <!-- App js -->
    <script src="{{ url('agroxa/horizontal-green/assets/js/app.js') }}"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
    toastr.options = {"positionClass": "toast-bottom-center"};
    @if(Session::has('flash_error'))
        toastr.error("{{ Session::get('flash_error') }}");
    @endif
    @if(Session::has('flash_success'))
        toastr.success("{{ Session::get('flash_success') }}");
    @endif
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            toastr.warning({{ $error }});

        @endforeach
    @endif
</script>


    @yield('scripts')

</body>
</html>
