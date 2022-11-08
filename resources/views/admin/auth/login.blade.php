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
                        <h4 class="text-muted font-18 m-b-5 text-center">Bem-Vindo!</h4>
                        <p class="text-muted text-center">Faça seu login para continuar usando o sistema.</p>

                        <form class="form-horizontal m-t-30"  method="POST" action="{{ url('/admin/login') }}">
                            <input type="hidden" name="login_type" value="admin">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" placeholder="E-mail" class="form-control" id="email" required data-validation-required-message="Informe o endereço de e-mail" autocomplete="off" @if(Setting::get('demo_mode', 0)==1)value="admin@demo.com"@endif>
                                        @if ($errors->has('email'))
                                            <p class="help-block text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                            </div>

                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" name="password" placeholder="Senha" class="form-control" id="password" required data-validation-required-message="Informe sua senha" autocomplete="off" @if(Setting::get('demo_mode', 0)==1)value="123456"@endif>
                                    @if ($errors->has('password'))
                                        <p class="help-block text-danger">{{ $errors->first('password') }}</p>
                                    @endif
                            </div>

                            <div class="form-group row m-t-20">
                                <div class="col-6">
                                    <!--
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">Lembrar-me</label>
                                    </div>
                                    -->
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Acessar</button>
                                </div>
                            </div>
                            <!--
                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-12 m-t-20">
                                    <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Recuperar Acesso</a>
                                </div>
                            </div>
                            -->
                        </form>
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
