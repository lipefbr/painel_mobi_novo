<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{ setting('site_title' , config('constants.site_title', 'Mobub')) }}</title>

        <link href="{{ url('agroxa/horizontal-green/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('agroxa/horizontal-green/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('agroxa/horizontal-green/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body>

        <!-- Background -->
        <div class="account-pages"></div>
        <!-- Begin page -->
        <div class="wrapper-page">

            <h3 class="text-center m-0">
                <a href="index.html" class="logo logo-admin"><img src="{{ setting('site_logo', config('constants.site_logo')) }}" height="50" alt="logo" style="margin-bottom: 28px"></a>
            </h3>

            <div class="card">
                <div class="card-body">

                    <div class="p-3">
                        <h4 class="text-muted font-18 m-b-5 text-center">Precisa de ajuda?</h4>
                        <p class="text-muted text-center">Estamos aqui para oferecer o melhor suporte. Entre em contato e vamos responder o mais rápido possível.</p>

                        <br>
                        <br>
                        <p>Precisa de ajuda? Fale conosco via e-mail:</p>
                        <p>{{ setting('contact_email') }}</p>
                    </div>
                </div>
            </div>

            <div class="m-t-40 text-center">
                
                <p class="text-muted">© Copyright {{ date('Y') }} - {{ setting('site_copyright' , config('constants.site_copyright', date('Y').' Mobub')) }}  <span class="d-none d-sm-inline-block"><i class="mdi mdi-heart text-danger"></i> </p>
            </div>

        </div>

        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="{{ url('agroxa/horizontal-green/assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('agroxa/horizontal-green/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('agroxa/horizontal-green/assets/js/jquery.slimscroll.js') }}"></script>

        <!-- App js -->
        <script src="{{ url('agroxa/horizontal-green/assets/js/app.js') }}"></script>

    </body>

</html>
