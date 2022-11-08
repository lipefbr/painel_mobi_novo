@extends('admin.layout.app')

@section('title', 'Configurações ')
@section('subtitle', 'Atualize pagamentos e outros dados')

@section('styles')
<link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('content')


<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <form action="{{ route('admin.settings.payment.store') }}" method="POST" enctype="multipart/form-data" role="form" autocomplete="off" id="form-payment">
                        {{csrf_field()}}

                        <div class="card-body">


                            <div class="row">
                                <div class="col-sm-6 border-right">
                                    <h4 class="mt-0 header-title mb-12">Alvos</h4>
                                    <br>
                                    <div class="form-group row">
                                        <label for="daily_target" class="col-sm-5 col-form-label">@lang('admin.payment.daily_target')</label>
                                        <div class="col-sm-7">
                                            <input class="form-control" 
                                            type="number"
                                            value="{{ setting('daily_target', config('constants.daily_target', '0')) }}"
                                            id="daily_target"
                                            name="daily_target"
                                            min="0"
                                            required
                                            placeholder="Daily Target">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tax_percentage" class="col-sm-5 col-form-label">@lang('admin.payment.tax_percentage')</label>
                                        <div class="col-sm-7">
                                            <input class="form-control"
                                            type="number"
                                            value="{{ setting('tax_percentage', config('constants.tax_percentage', '0'))  }}"
                                            id="tax_percentage"
                                            name="tax_percentage"
                                            min="0"
                                            max="100"
                                            placeholder="Tax Percentage">
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="commission_percentage" class="col-sm-5 col-form-label">@lang('admin.payment.commission_percentage')</label>
                                        <div class="col-sm-7">
                                            <input class="form-control"
                                            type="number"
                                            value="{{ setting('commission_percentage', config('constants.commission_percentage', '0')) }}"
                                            id="commission_percentage"
                                            name="commission_percentage"
                                            min="0"
                                            max="100"
                                            placeholder="@lang('admin.payment.commission_percentage')">
                                        </div>
                                    </div>                        


                                    <div class="form-group row">
                                        <label for="peak_percentage" class="col-sm-5 col-form-label">@lang('admin.payment.peak_percentage')</label>
                                        <div class="col-sm-7">
                                            <input class="form-control"
                                            type="number"
                                            value="{{ setting('peak_percentage', config('constants.peak_percentage', '0')) }}"
                                            id="peak_percentage"
                                            name="peak_percentage"
                                            min="0"
                                            max="100"
                                            placeholder="@lang('admin.payment.peak_percentage')">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="waiting_percentage" class="col-sm-5 col-form-label">@lang('admin.payment.waiting_percentage')</label>
                                        <div class="col-sm-7">
                                            <input class="form-control"
                                            type="number"
                                            value="{{ setting('waiting_percentage', config('constants.waiting_percentage', '0')) }}"
                                            id="waiting_percentage"
                                            name="waiting_percentage"
                                            min="0"
                                            max="100"
                                            placeholder="@lang('admin.payment.waiting_percentage')">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="minimum_negative_balance" class="col-sm-5 col-form-label">@lang('admin.payment.minimum_negative_balance')</label>
                                        <div class="col-sm-7">
                                            <input class="form-control"
                                            type="number"
                                            value="{{ setting('minimum_negative_balance', config('constants.minimum_negative_balance')) }}"
                                            id="minimum_negative_balance"
                                            name="minimum_negative_balance"
                                            max='0'
                                            placeholder="@lang('admin.payment.minimum_negative_balance')">
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label for="minimum_negative_balance" class="col-sm-5 col-form-label">Saque mínimo Franquia</label>
                                        <div class="col-sm-7">
                                            <input class="form-control"
                                            type="number"
                                            value="{{ setting('minimum_withdraw_fleet', 1) }}"
                                            id="minimum_withdraw_fleet"
                                            name="minimum_withdraw_fleet"
                                            min='1'
                                            required 
                                            placeholder="Valor Mínimo Para Saque">
                                        </div>
                                    </div>
                                </div>
                                @can('payment-settings')
                                <div class="col-sm-6">
                                    <h4 class="mt-0 header-title mb-4">Pagamentos</h4>
                                    <br>

                                    <div class="form-group row">
                                        <div class="col-sm-3 arabic_right">
                                            <label for="cash-payments" class="col-form-label">
                                                @lang('admin.payment.cash_payments') 
                                            </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="cash" type="checkbox" class="js-switch" data-color="#43b968" id="cash-payments" switch="none" @if(setting('cash', config('constants.cash')) == "on") checked  @endif  />
                                            <label for="cash-payments" data-on-label="SIM"
                                            data-off-label="NÃO"></label>


                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-3 arabic_right">
                                            <label for="stripe_secret_key" class="col-form-label">
                                                @lang('admin.payment.card_payments')
                                            </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="card" type="checkbox" class="js-switch" data-color="#43b968" id="stripe_check" switch="none" @if(setting('card', config('constants.card')) == 'on') checked  @endif  />
                                            <label for="stripe_check" data-on-label="SIM"
                                            data-off-label="NÃO"></label>

                                        </div>
                                    </div>
                                    <div class="payment_settings" @if(setting('card', config('constants.card')) != 'on') style="display: none;" @endif>
                                        <div class="form-group row">
                                            <label for="stripe_secret_key" class="col-sm-3 col-form-label">@lang('admin.payment.stripe_secret_key')</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" value="{{ setting('stripe_secret_key', config('constants.stripe_secret_key')) }}" name="stripe_secret_key" id="stripe_secret_key"  placeholder="@lang('admin.payment.stripe_secret_key')" @if(!Auth::user()->isSuperAdmin()) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stripe_publishable_key" class="col-sm-3 col-form-label">@lang('admin.payment.stripe_publishable_key')</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" value="{{ setting('stripe_publishable_key', config('constants.stripe_publishable_key')) }}" name="stripe_publishable_key" id="stripe_publishable_key"  placeholder="@lang('admin.payment.stripe_publishable_key')" @if(!Auth::user()->isSuperAdmin()) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stripe_currency" class="col-sm-3 col-form-label">@lang('admin.payment.currency')</label>
                                            <div class="col-sm-9">
                                                <select name="stripe_currency" class="form-control" required>
                                                    <option @if( setting('stripe_currency', config('constants.stripe_currency')) == "BRL") selected @endif value="BRL">BRL</option>
                                                    <option @if( setting('stripe_currency', config('constants.stripe_currency')) == "USD") selected @endif value="USD">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stripe_publishable_key" class="col-sm-3 col-form-label">Taxa Stripe</label>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="text" value="{{ setting('tax_gatway', 0.50) }}" name="tax_gatway"  placeholder="Fixa">
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control" type="text" value="{{ setting('tax_per_gatway', 2.50) }}" name="tax_per_gatway" placeholder="Porcentagem">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <div class="col-sm-3 arabic_right">
                                            <label for="debit-machine-payments" class="col-form-label">
                                                @lang('admin.payment.debit_machine_payments')
                                            </label>
                                        </div>
                                        <div class="col-sm-9">

                                            <input name="debit_machine" type="checkbox" class="js-switch" data-color="#43b968" id="debit-machine-payments" switch="none" @if(setting('debit_machine', config('constants.debit_machine')) == 'on') checked  @endif  />
                                            <label for="debit-machine-payments" data-on-label="SIM"
                                            data-off-label="NÃO"></label>
                                        </div>

                                    </div>

                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Taxa Maquininha</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" value="{{ setting('tax_gatway_machine', 0.50) }}" name="tax_gatway_machine"  placeholder="Fixa">
                                        </div>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" value="{{ setting('tax_per_gatway_machine', 2.50) }}" name="tax_per_gatway_machine" placeholder="Porcentagem">
                                        </div>
                                    </div>

                                    <!--
                                    <div class="form-group row">
                                        <div class="col-sm-3 arabic_right">
                                            <label for="voucher-payments" class="col-form-label">
                                                @lang('admin.payment.voucher_payments')
                                            </label>
                                        </div>
                                        <div class="col-sm-9">

                                            <input name="voucher" type="checkbox" class="js-switch" data-color="#43b968" id="voucher-payments" switch="none" @if(setting('voucher', config('constants.voucher')) == 'on') checked  @endif/>
                                            <label for="voucher-payments" data-on-label="SIM"
                                            data-off-label="NÃO"></label>


                                        </div>
                                    </div>
                                    -->

                                </div>
                                @endcan

                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary ">Atualizar Alvos e Pagamentos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<br>
<br>
<br>

@can('settings-general')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card m-b-20">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" role="form" autocomplete="off">
                        {{csrf_field()}}

                        <div class="card-body">

                            <h4 class="mt-0 header-title">Configurações Gerais</h4>
                            <br>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#general" role="tab">Geral</a>
                                </li>
                                @can('settings-social-links')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#social-tab" role="tab">Social e Apps Links</a>
                                </li>
                                @endcan
                                @can('settings-social-login')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#socialConfiguration-tab" role="tab">Login Redes Sociais</a>
                                </li>
                                @endcan
                                @can('settings-search-algo')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#provider-tab" role="tab">Algorítimo de Pesquisa</a>
                                </li>
                                @endcan
                                @can('settings-maps-keys')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#api" role="tab">Mapa e Facebook Keys</a>
                                </li>
                                @endcan
                                @can('settings-email')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#email" role="tab">E-mail</a>
                                </li>
                                @endcan
                                @can('settings-push')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#pushnotification" role="tab">Notificações Push</a>
                                </li>
                                @endcan
                                @can('settings-other')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#others" role="tab">Outros</a>
                                </li>
                                @endcan
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content form-horizontal">
                                <div class="tab-pane active p-3" id="general" role="tabpanel">


                                    <div class="form-group row">
                                        <label for="site_title" class="col-sm-2 col-form-label">@lang('admin.setting.Site_Name')</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" value="{{ setting('site_title', config('constants.site_title', 'MuLambo'))  }}" name="site_title" required id="site_title" placeholder="@lang('admin.setting.Site_Name')">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="site_logo" class="col-sm-2 col-form-label">@lang('admin.setting.Site_Logo')</label>
                                        <div class="col-sm-10">
                                            @if(setting('site_logo', config('constants.site_logo'))!='')
                                            <img style="height: 90px; margin-bottom: 15px;" src="{{ setting('site_logo', config('constants.site_logo', asset('logo-black.png'))) }}">
                                            @endif
                                            <input type="file" accept="image/*" name="site_logo" class="dropify form-control-file" id="site_logo" aria-describedby="fileHelp">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="site_icon" class="col-sm-2 col-form-label">@lang('admin.setting.Site_Icon')</label>
                                        <div class="col-sm-10">
                                            @if( setting('site_icon',config('constants.site_icon'))!='')
                                            <img style="height: 90px; margin-bottom: 15px;" src="{{  setting('site_icon', config('constants.site_icon')) }}">
                                            @endif
                                            <input type="file" accept="image/*" name="site_icon" class="dropify form-control-file" id="site_icon" aria-describedby="fileHelp">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="skin" class="col-sm-2 col-form-label">@lang('admin.setting.site_skin')</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="skin" name="menu_skin" autocomplete="off">
                                                <option value="skin-1" @if(setting('menu_skin', 'skin-1') == 'skin-1') selected @endif>Roxo</option>
                                                <option value="skin-2" @if(setting('menu_skin', 'skin-2') == 'skin-2') selected @endif>Preto</option>
                                                <option value="skin-3" @if(setting('menu_skin', 'skin-3') == 'skin-3') selected @endif>Branco & Cinza</option>
                                                <option value="skin-5" @if(setting('menu_skin', 'skin-5') == 'skin-5') selected @endif>Verde</option>
                                                <option value="skin-6" @if(setting('menu_skin', 'skin-6') == "skin-6") selected @endif>Vermelho</option>
                                                <option value="skin-7" @if(setting('menu_skin', 'skin-7') == 'skin-7') selected @endif>Azul</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="timezone" class="col-sm-2 col-form-label">@lang('admin.setting.timezone')</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="timezone" name="timezone" autocomplete="off">
                                                <option value="UTC" @if(Config::get('constants.timezone') == 'UTC') selected @endif>Selecione o Timezone</option>
                                                <option value="America/Rio_branco" @if(Config::get('constants.timezone') == 'America/Rio_branco') selected @endif>AC/Rio Branco</option>
                                                <option value="America/Belem" @if(Config::get('constants.timezone') == 'America/Belem') selected @endif>AP/Macapá</option>
                                                <option value="America/Maceio" @if(Config::get('constants.timezone') == 'America/Maceio') selected @endif>AL/Maceio</option>
                                                <option value="America/Manaus" @if(Config::get('constants.timezone') == 'America/Manaus') selected @endif>AM/Manaus</option>
                                                <option value="America/Bahia" @if(Config::get('constants.timezone') == 'America/Bahia') selected @endif>BA/Salvador</option
                                                    <option value="America/Fortaleza" @if(Config::get('constants.timezone') == 'America/Fortaleza') selected @endif>CE/Fortaleza</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>DF/Brasília</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Porto_Velho') selected @endif>ES/Vitória</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>GO/Goiania</option>
                                                    <option value="America/Cuiaba" @if(Config::get('constants.timezone') == 'America/Cuiaba') selected @endif>MT/Cuiabá</option>
                                                    <option value="America/Campo_Grande" @if(Config::get('constants.timezone') == 'America/Campo_Grande') selected @endif>MS/Campo Grande</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>MG/Belo Horizonte</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>PR/Curitiba</option>
                                                    <option value="America/Fortaleza" @if(Config::get('constants.timezone') == 'America/Fortaleza') selected @endif>PB/João Pessoa</option>
                                                    <option value="America/Belem" @if(Config::get('constants.timezone') == 'America/Belem') selected @endif>PA/Belém</option>
                                                    <option value="America/Recife" @if(Config::get('constants.timezone') == 'America/Recife') selected @endif>PE/Pernambuco</option>
                                                    <option value="America/Fortaleza" @if(Config::get('constants.timezone') == 'America/Fortaleza') selected @endif>PI/Terezina</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>RJ/Rio de Janeiro</option>
                                                    <option value="America/fortaleza" @if(Config::get('constants.timezone') == 'America/fortaleza') selected @endif>RN/Natal</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>RS/Porto Alegre</option>
                                                    <option value="America/Porto_Velho" @if(Config::get('constants.timezone') == 'America/Porto_Velho') selected @endif>RO/Porto Velho</option>
                                                    <option value="America/Boa_Vista" @if(Config::get('constants.timezone') == 'America/Boa_Bista') selected @endif>RR/Boa Vista</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>SC/Florianópolis</option>
                                                    <option value="America/Maceio" @if(Config::get('constants.timezone') == 'America/Maceio') selected @endif>SE/Maceió</option>
                                                    <option value="America/Sao_Paulo" @if(Config::get('constants.timezone') == 'America/Sao_Paulo') selected @endif>SP/São Paulo</option>
                                                    <option value="America/Araguaia" @if(Config::get('constants.timezone') == 'America/Araguaia') selected @endif>TO/Palmas</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="contact_number" class="col-sm-2 col-form-label">@lang('admin.setting.Contact_Number')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control cell_phone" type="text" value="{{ setting('contact_number', config('constants.contact_number', '911'))  }}" name="contact_number" required id="contact_number" placeholder="@lang('admin.setting.Contact_Number')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="contact_email" class="col-sm-2 col-form-label">@lang('admin.setting.Contact_Email')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="email" value="{{ setting('contact_email', config('constants.contact_email', ''))  }}" name="contact_email" required id="contact_email" placeholder="@lang('admin.setting.Contact_Email')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sos_number" class="col-sm-2 col-form-label">@lang('admin.setting.SOS_Number')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{ setting('sos_number', config('constants.sos_number', '911'))  }}" name="sos_number" required id="sos_number" placeholder="@lang('admin.setting.SOS_Number')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tax_percentage" class="col-sm-2 col-form-label">@lang('admin.setting.Copyright_Content')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('site_copyright', config('constants.site_copyright', '&copy; '.date('Y').' Appoets')) }}" name="site_copyright" id="site_copyright" placeholder="@lang('admin.setting.Copyright_Content')">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- SOCIAL TAP -->

                                    <div class="tab-pane p-3" id="social-tab" role="tabpanel">

                                        <div class="form-group row">
                                            <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.Android_user_link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_link_android_user', config('constants.store_link_android_user', ''))  }}" name="store_link_android_user"  id="store_link_android_user" placeholder="@lang('admin.setting.Android_user_link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">@lang('admin.setting.Android_provider_link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_link_android_provider', config('constants.store_link_android_provider', ''))  }}" name="store_link_android_provider"  id="store_link_android_provider" placeholder="@lang('admin.setting.Android_provider_link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">@lang('admin.setting.Ios_user_Link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_link_ios_user', config('constants.store_link_ios_user', ''))  }}" name="store_link_ios_user"  id="store_link_ios_user" placeholder="@lang('admin.setting.Ios_user_Link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">@lang('admin.setting.Ios_provider_Link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_link_ios_provider', config('constants.store_link_ios_provider', ''))  }}" name="store_link_ios_provider"  id="store_link_ios_provider" placeholder="@lang('admin.setting.Ios_provider_Link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">@lang('admin.setting.Facebook_Link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_facebook_link', config('constants.store_facebook_link', ''))  }}" name="store_facebook_link"  id="store_facebook_link" placeholder="@lang('admin.setting.Facebook_Link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">@lang('admin.setting.Instagram_Link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_instagram_link', config('constants.store_instagram_link', ''))  }}" name="store_instagram_link"  id="store_instagram_link" placeholder="@lang('admin.setting.Instagram_Link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">@lang('admin.setting.Twitter_Link')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('store_twitter_link', config('constants.store_twitter_link', ''))  }}" name="store_twitter_link"  id="store_twitter_link" placeholder="@lang('admin.setting.Twitter_Link')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">Versão App Andorid Passageiro</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('version_android_user', config('constants.version_android_user', ''))  }}" name="version_android_user"  id="version_android_user" placeholder="Código da Versão">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">Versão App Andorid Motorista</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('version_android_provider', config('constants.version_android_provider', ''))  }}" name="version_android_provider"  id="version_android_provider" placeholder="Código da Versão">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">Versão App IOS Passageiro</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('version_ios_user', config('constants.version_ios_user', ''))  }}" name="version_ios_user"  id="version_ios_user" placeholder="Código da Versão">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="store_link_ios" class="col-sm-2 col-form-label">Versão App IOS Motorista</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('version_ios_provider', config('constants.version_ios_provider', ''))  }}" name="version_ios_provider"  id="version_ios_provider" placeholder="Código da Versão">
                                            </div>
                                        </div>



                                    </div>

                                    <div class="tab-pane p-3" id="socialConfiguration-tab" role="tabpanel">

                                        <div class="form-group row">
                                            <label for="social_login" class="col-sm-2 col-form-label">@lang('admin.setting.Social_Login')</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="social_login" name="social_login" autocomplete="off">
                                                    <option value="1" @if(setting('social_login', config('constants.social_login', 0)) == 1) selected @endif>@lang('admin.Enable')</option>
                                                    <option value="0" @if(setting('social_login', config('constants.social_login', 0)) == 0) selected @endif>@lang('admin.Disable')</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="social_container" style=" @if(setting('social_login',config('constants.social_login', 0)) == 0) display: none;  @endif  ">
                                            <hr>
                                            <div class="form-group row">
                                                <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.facebook_client_id')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="{{ setting('facebook_client_id', Config::get('constants.facebook_client_id'))  }}" name="facebook_client_id"  id="facebook_client_id" placeholder="@lang('admin.setting.facebook_client_id')">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.facebook_client_secret')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="{{ setting('facebook_client_secret', Config::get('constants.facebook_client_secret'))  }}" name="facebook_client_secret"  id="facebook_client_secret" placeholder="@lang('admin.setting.facebook_client_secret')">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.facebook_redirect')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="{{ setting('facebook_redirect', Config::get('constants.facebook_redirect'))  }}" name="facebook_redirect"  id="facebook_redirect" placeholder="@lang('admin.setting.facebook_redirect')">
                                                </div>
                                            </div>

                                            <br><br>


                                            <div class="form-group row">
                                                <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.google_client_id')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="{{ setting('google_client_id', Config::get('constants.google_client_id'))  }}" name="google_client_id"  id="google_client_id" placeholder="@lang('admin.setting.google_client_id')">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.google_client_secret')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="{{ setting('google_client_secret', Config::get('constants.google_client_secret'))  }}" name="google_client_secret"  id="google_client_secret" placeholder="@lang('admin.setting.google_client_secret')">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="store_link_android" class="col-sm-2 col-form-label">@lang('admin.setting.google_redirect')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="{{ setting('google_redirect', Config::get('constants.google_redirect'))  }}" name="google_redirect"  id="google_redirect" placeholder="@lang('admin.setting.google_redirect')">
                                                </div>
                                            </div>

                                            <hr>
                                        </div>


                                    </div>

                                    <div class="tab-pane p-3" id="provider-tab" role="tabpanel">
                                        <div class="form-group row">
                                            <label for="provider_select_timeout" class="col-sm-2 col-form-label">@lang('admin.setting.Provider_Accept_Timeout') (Secs)</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{ setting('provider_select_timeout', config('constants.provider_select_timeout', '60'))  }}" name="provider_select_timeout" required id="provider_select_timeout" placeholder="Provider Timout">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="provider_search_radius" class="col-sm-2 col-form-label">@lang('admin.setting.Provider_Search_Radius') (Kms)</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{ setting('provider_search_radius', config('constants.provider_search_radius', '100'))  }}" name="provider_search_radius" required id="provider_search_radius" placeholder="Provider Search Radius">
                                            </div>
                                        </div>



                                        <div class="form-group row">
                                            <label for="distance" class="col-sm-2 col-form-label">@lang('admin.setting.distance')</label>
                                            <div class="col-sm-10">
                                                <select name="distance" class="form-control">
                                                    <option value="Kms" @if(setting('distance', config('constants.distance')) == 'Kms') selected @endif>Kms</option>
                                                    <option value="Miles" @if(setting('distance', config('constants.distance')) == 'Miles') selected @endif>Miles</option>
                                                </select>   
                                            </div>
                                        </div>

                                    </div>


                                    <div class="tab-pane p-3" id="api" role="tabpanel">
                                        <div class="form-group row">

                                            <label for="map_key" class="col-sm-2 col-form-label">@lang('admin.setting.map_key')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('map_key', Config::get('constants.map_key'))  }}" name="map_key" required id="map_key" placeholder="@lang('admin.setting.map_key')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="facebook_app_version" class="col-sm-2 col-form-label">@lang('admin.setting.fb_app_version')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('facebook_app_version', Config::get('constants.facebook_app_version'))  }}" name="facebook_app_version" required id="facebook_app_version" placeholder="@lang('admin.setting.fb_app_version')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="facebook_app_id" class="col-sm-2 col-form-label">@lang('admin.setting.fb_app_id')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('facebook_app_id', Config::get('constants.facebook_app_id'))  }}" name="facebook_app_id" required id="facebook_app_id" placeholder="@lang('admin.setting.fb_app_id')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="facebook_app_secret" class="col-sm-2 col-form-label">@lang('admin.setting.fb_app_secret')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('facebook_app_secret', Config::get('constants.facebook_app_secret'))  }}" name="facebook_app_secret" required id="facebook_app_secret" placeholder="@lang('admin.setting.fb_app_secret')">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane p-3" id="email" role="tabpanel">
                                        <div class="form-group row" id="mail_request">
                                            <label for="stripe_secret_key" class="col-sm-2 col-form-label"> @lang('admin.setting.send_mail') </label>
                                            <div class="col-sm-10">
                                                <div class="float-xs-left mr-1">

                                                    <input name="send_email" type="checkbox" class="js-switch" data-color="#43b968" id="mailchk" switch="none" @if(setting('send_email', config('constants.send_email')) == 'on') checked  @endif/>
                                                    <label for="mailchk" data-on-label="SIM"
                                                    data-off-label="NÃO"></label>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="social_login" class="col-sm-2 col-form-label">@lang('admin.setting.mail_driver')</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="mail_driver" required id="mail_driver">
                                                    <option value="SMTP" @if(setting('mail_driver', config('constants.mail_driver')) == 'SMTP') selected @endif>@lang('admin.setting.smtp')</option>
                                                    <option value="MAILGUN" @if(setting('mail_driver', config('constants.mail_driver')) == 'MAILGUN') selected @endif>@lang('admin.setting.mailgun')</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_host" class="col-sm-2 col-form-label">@lang('admin.setting.mail_host')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_host', config('constants.mail_host'))  }}" name="mail_host" required id="mail_host" placeholder="@lang('admin.setting.mail_host')">
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_port" class="col-sm-2 col-form-label">@lang('admin.setting.mail_port')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_port', config('constants.mail_port'))  }}" name="mail_port" required id="mail_port" placeholder="@lang('admin.setting.mail_port')">
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_username" class="col-sm-2 col-form-label">@lang('admin.setting.mail_username')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_username', config('constants.mail_username'))  }}" name="mail_username" required id="mail_username" placeholder="@lang('admin.setting.mail_username')" >
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_password" class="col-sm-2 col-form-label">@lang('admin.setting.mail_password')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_password',  config('constants.mail_password'))  }}" name="mail_password" required id="mail_password" placeholder="@lang('admin.setting.mail_password')" >
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_from_address" class="col-sm-2 col-form-label">@lang('admin.setting.mail_from_address')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="email" value="{{ setting('mail_from_address', config('constants.mail_from_address'))  }}" name="mail_from_address" required id="mail_from_address" placeholder="@lang('admin.setting.mail_from_address')" >
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_from_name" class="col-sm-2 col-form-label">@lang('admin.setting.mail_from_name')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_from_name', config('constants.mail_from_name'))  }}" name="mail_from_name" required id="mail_from_name" placeholder="@lang('admin.setting.mail_from_name')" >
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail">
                                            <label for="mail_encryption" class="col-sm-2 col-form-label">@lang('admin.setting.mail_encryption')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_encryption', config('constants.mail_encryption'))  }}" name="mail_encryption" required id="mail_encryption" placeholder="@lang('admin.setting.mail_encryption')" >
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail mail_domain">
                                            <label for="mail_domain" class="col-sm-2 col-form-label">@lang('admin.setting.mail_domain')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{  setting('mail_domain', config('constants.mail_domain'))  }}" name="mail_domain" id="mail_domain" placeholder="@lang('admin.setting.mail_domain')" >
                                            </div>
                                        </div>

                                        <div class="form-group row hidemail mail_secret">
                                            <label for="mail_secret" class="col-sm-2 col-form-label">@lang('admin.setting.mail_secret')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ setting('mail_secret',  config('constants.mail_secret')) }}" name="mail_secret" id="mail_secret" placeholder="@lang('admin.setting.mail_secret')" >
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane p-3" id="pushnotification" role="tabpanel">


                                        <div class="form-group row">
                                            <label for="mail_driver" class="col-sm-2 col-form-label">@lang('admin.setting.ios_push_user_pem')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" value="" name="user_pem" id="user_pem" placeholder="@lang('admin.setting.ios_push_user_pem')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="mail_driver" class="col-sm-2 col-form-label">@lang('admin.setting.ios_push_provider_pem')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" value="" name="provider_pem" id="provider_pem" placeholder="@lang('admin.setting.ios_push_provider_pem')">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane p-3" id="others" role="tabpanel">

                                        {{-- 
                                        <div class="form-group row" id="referral_request">
                                            <label for="stripe_secret_key" class="col-sm-2 col-form-label"> @lang('admin.setting.referral') </label>
                                            <div class="col-sm-10">
                                                <input name="referral" type="checkbox" class="js-switch" data-color="#43b968" id="refchk" switch="none" 
                                                @if(setting('referral', config('constants.referral')) == "on") checked  @endif/>
                                                <label for="refchk" data-on-label="SIM"
                                                data-off-label="NÃO"></label>

                                            </div>
                                        </div>
                                        --}}

                                        <div class="form-group row hideref">
                                            <label for="referral_count" class="col-sm-2 col-form-label">@lang('admin.setting.referral_count')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{ setting('referral_count', config('constants.referral_count'))  }}" name="referral_count" required id="referral_count" placeholder="@lang('admin.setting.referral_count')" min="0">
                                            </div>
                                        </div>

                                        <div class="form-group row hideref">
                                            <label for="referral_amount" class="col-sm-2 col-form-label">@lang('admin.setting.referral_amount')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{  setting('referral_amount', config('constants.referral_amount'))  }}" name="referral_amount" required id="referral_amount" placeholder="@lang('admin.setting.referral_amount')" min="0">
                                            </div>
                                        </div> 
                                        {{--
                                        <div class="form-group row">
                                            <label for="stripe_secret_key" class="col-sm-2 col-form-label"> Atribuição Manual </label>
                                            <div class="col-sm-10">
                                                <div class="float-xs-left mr-1">

                                                    <input name="manual_request" type="checkbox" class="js-switch" data-color="#43b968" id="manual_request" switch="none" @if( setting('manual_request', config('constants.manual_request')) == 'on') checked  @endif/>
                                                    <label for="manual_request" data-on-label="SIM"
                                                    data-off-label="NÃO"></label>

                                                </div>
                                            </div>
                                        </div>
                                        --}}


                                        <div class="form-group row" id="broadcast_request">
                                            <label id="unicast" for="broadcast_request" class="col-sm-2 col-form-label">Solici Única/Simultanea </label>
                                            <div class="col-sm-10">
                                                <div class="float-xs-left mr-1">

                                                    <input name="broadcast_request" type="checkbox" class="js-switch" data-color="#43b968" id="bdchk" switch="none" @if(setting('broadcast_request', config('constants.broadcast_request')) == 'on') checked  @endif/>
                                                    <label for="bdchk" data-on-label="SMU"
                                                    data-off-label="UNC"></label>

                                                </div>
                                            </div>
                                            <label id="broadcast" for="broadcast_request" class="col-xs-2 col-form-label"></label>
                                        </div>

                                        <div class="form-group row">
                                            <label for="stripe_secret_key" class="col-sm-2 col-form-label">Verificação OTP</label>
                                            <div class="col-sm-10">
                                                <div class="float-xs-left mr-1">


                                                    <input name="ride_otp" type="checkbox" class="js-switch" data-color="#43b968" id="ride_otp" switch="none" @if(setting('ride_otp', config('constants.ride_otp')) == 'on') checked  @endif/>
                                                    <label for="ride_otp" data-on-label="SIM"
                                                    data-off-label="NÃO"></label>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="stripe_secret_key" class="col-sm-2 col-form-label">Verificação Pedágio</label>
                                            <div class="col-sm-10">
                                                <div class="float-xs-left mr-1">

                                                    <input name="ride_toll" type="checkbox" class="js-switch" data-color="#43b968" id="ride_toll" switch="none" @if(setting('ride_toll', config('constants.ride_toll')) == 'on') checked  @endif />
                                                    <label for="ride_toll" data-on-label="SIM"
                                                    data-off-label="NÃO"></label>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="booking_prefix" class="col-sm-2 col-form-label">@lang('admin.payment.booking_id_prefix')</label>
                                            <div class="col-sm-10">
                                                <input class="form-control"
                                                type="text"
                                                value="{{ setting('booking_prefix', config('constants.booking_prefix', 'MOBUB')) }}"
                                                id="booking_prefix"
                                                name="booking_prefix"
                                                min="0"
                                                max="4"
                                                placeholder="Booking ID Prefix">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="base_price" class="col-sm-2 col-form-label">@lang('admin.payment.currency')
                                                ( <strong>{{ config('constants.currency', '$')  }} </strong>)
                                            </label>
                                            <div class="col-sm-10">
                                                <select name="currency" class="form-control" required>
                                                    <option @if(config('constants.currency') == "R$") selected @endif value="R$">Real (BRL)</option>
                                                    <option @if(config('constants.currency') == "$") selected @endif value="$">US Dollar (USD)</option>
                                                    <option @if(config('constants.currency') == "₹") selected @endif value="₹"> Indian Rupee (INR)</option>
                                                    <option @if(config('constants.currency') == "د.ك") selected @endif value="د.ك">Kuwaiti Dinar (KWD)</option>
                                                    <option @if(config('constants.currency') == "د.ب") selected @endif value="د.ب">Bahraini Dinar (BHD)</option>
                                                    <option @if(config('constants.currency') == "﷼") selected @endif value="﷼">Omani Rial (OMR)</option>
                                                    <option @if(config('constants.currency') == "£") selected @endif value="£">British Pound (GBP)</option>
                                                    <option @if(config('constants.currency') == "€") selected @endif value="€">Euro (EUR)</option>
                                                    <option @if(config('constants.currency') == "CHF") selected @endif value="CHF">Swiss Franc (CHF)</option>
                                                    <option @if(config('constants.currency') == "ل.د") selected @endif value="ل.د">Libyan Dinar (LYD)</option>
                                                    <option @if(config('constants.currency') == "B$") selected @endif value="B$">Bruneian Dollar (BND)</option>
                                                    <option @if(config('constants.currency') == "S$") selected @endif value="S$">Singapore Dollar (SGD)</option>
                                                    <option @if(config('constants.currency') == "AU$") selected @endif value="AU$"> Australian Dollar (AUD)</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary ">Atualizar Configurações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan


    @endsection

    @section('scripts')

<script type="text/javascript" src="{{asset('main/vendor/dropify/dist/js/dropify.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/assets/js/forms-upload.js')}}"></script>
<script src="{{ url('asset/js/mask/jquery.mask.js') }}"></script>
<script type="text/javascript">

    $('.cell_phone').mask('(00) 0 0000-0000');

    $("input:checkbox").change(function() {
        if ($(this).attr("checked") == "checked") {
            $(this).attr("checked", false);
        //$(this).attr("value", 0);
        } else {
            $(this).attr("checked", true);
        //$(this).attr("value", 'on');
        }
    // console.log($(this).attr("checked"));
    //var add_name = $('#add_name').val();
    //$("#form-add input:checkbox").attr("checked", false);
    //$("#form-payment")[0].reset();
    });

//switchbroadcast();
switchreferral();
switchmail();
switchMailDomain();
$('#broadcast_request').click(function (e) {
//switchbroadcast();
});
$('#referral_request').click(function (e) {
    switchreferral();
});
$('#mail_request').click(function (e) {
    switchmail();
    switchMailDomain();
});
$('#mail_driver').click(function (e) {
    switchMailDomain();
});


$('select[name=social_login]').on('change', function (e) {
    var value = $(this).val();
    $('.social_container').hide();
    $('.social_container input').prop('disabled', true);
    if (value == 1) {
        $('.social_container').show();
        $('.social_container input').prop('disabled', false);
    }

});

/*
function switchbroadcast() {
    var isChecked = $("#bdchk").is(":checked");
    if (isChecked) {
        $("#broadcast").text('Solicitação Simultânea');
        $("#unicast").text('');
    } else {
        $("#unicast").text('Solicitação Única');
        $("#broadcast").text('');
    }
}
*/



function switchmail() {
    var isChecked = $("#mailchk").is(":checked");
    if (isChecked) {
        //$(".hidemail").find('input').attr('required', true);
        $("#mail_host").attr('required', true);
        $("#mail_port").attr('required', true);
        $("#mail_username").attr('required', true);
        $("#mail_from_address").attr('required', true);
        $("#mail_from_name").attr('required', true);
        $("#mail_password").attr('required', true);
        $("#mail_encryption").attr('required', true);
        $(".hidemail").show();
    } else {
        $("#mail_host").attr('required', false);
        $("#mail_port").attr('required', false);
        $("#mail_username").attr('required', false);
        $("#mail_from_address").attr('required', false);
        $("#mail_from_name").attr('required', false);
        $("#mail_password").attr('required', false);
        $("#mail_encryption").attr('required', false);
        $(".hidemail").hide();
    }
}


function switchreferral() {
    var isChecked = $("#refchk").is(":checked");
    if (isChecked) {
        $(".hideref").show();
    } else {
        $(".hideref").hide();
    }
}

function switchMailDomain() {
    var mailDriver = $("#mail_driver").val();
    if (mailDriver == "SMTP") {
        $(".hidemail").find('.mail_secret').attr('required', false);
        $(".hidemail").find('.mail_domain').attr('required', false);
        $(".mail_secret").hide();
        $(".mail_domain").hide();
    } else {
        $(".hidemail").find('.mail_secret').attr('required', true);
        $(".hidemail").find('.mail_domain').attr('required', true);
        $(".mail_secret").show();
        $(".mail_domain").show();
    }
}





$('#stripe_check').on('change', function() {
    if($(this).is(':checked')) {
// console.log($(this).closest('blockquote').find('.payment_settings'));

$(".payment_settings").fadeIn(700);
//$(this).closest('blockquote').find('.payment_settings').fadeIn(700);
} else {
    $(".payment_settings").fadeOut(700);
//$(this).closest('blockquote').find('.payment_settings').fadeOut(700);
}



});


$(function() {
    var ad_com="{{ config('constants.commission_percentage') }}";   
    if(ad_com>0){        
        $("#fleet_commission_percentage").val(0);
        $("#fleet_commission_percentage").prop('disabled', true);
        $("#fleet_commission_percentage").prop('required', false);       
    }
    else{
        $("#fleet_commission_percentage").prop('required', true);
    }
    $("#commission_percentage").on('keyup', function(){
        var ad_ins=parseFloat($(this).val());
// console.log(ad_ins);
if(ad_ins>0){
    $("#fleet_commission_percentage").val(0);
    $("#fleet_commission_percentage").prop('disabled', true);
    $("#fleet_commission_percentage").prop('required', false);
}
else{
    $("#fleet_commission_percentage").val('');
    $("#fleet_commission_percentage").prop('disabled', false);
    $("#fleet_commission_percentage").prop('required', true);
}

});
});    
</script>
@endsection