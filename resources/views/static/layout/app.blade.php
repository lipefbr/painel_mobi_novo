<!DOCTYPE html>
<html lang="pr-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ setting('site_title', config('constants.site_title')) }}</title>

        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon') }}"/>

        <link href="{{asset('asset/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('asset/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper">
            <div id="page-content-wrapper">
            
                @yield('content')
                
            </div>
        </div>

        <script src="{{asset('asset/js/jquery.min.js')}}"></script>
        <script src="{{asset('asset/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('asset/js/scripts.js')}}"></script>
        @yield('scripts')
    </body>
</html>
