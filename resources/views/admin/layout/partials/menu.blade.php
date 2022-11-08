<!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            {{-- 
                            @role('ADMIN|ACCOUNT')
                            @endrole
                            --}}

                            @can('dashboard-menus')
                            <li>
                                <a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home"></i>@lang('admin.include.dashboard')</a>
                            </li>
                            @endcan

                            @can('dispatcher-panel')
                            <li>
                                <a href="{{ route('admin.dispatcher.index') }}"><i class="mdi mdi-console-network"></i>Despache</a>
                            </li>
                            @endcan


                            @can('dispute-menu')
                            <li class="has-submenu">
                                <a href="#">
                                    <i class="mdi mdi-credit-card-off"></i>
                                    @lang('admin.include.dispute_panel')
                                    @if($disputes_count > 0)
                                    <span class="badge badge-pill badge-danger">{{ $disputes_count }}</span>
                                    @endif
                                </a>
                                <ul class="submenu">
                                    @can('dispute-list')
                                    <li><a href="{{ route('admin.userdisputes') }}">@lang('admin.include.dispute_request')</a></li>
                                    @endcan

                                    @can('dispute-type')
                                    <li><a href="{{ route('admin.dispute.index') }}">@lang('admin.include.dispute_type')</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan

                            @can('god-eye')
                                <li><a href="{{ route('admin.godseye') }}"><i class="mdi mdi-eye"></i> @lang('admin.heatmap.godseye')</a></li>
                            @endcan

                            @can('registrations-button')
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-buffer"></i>Cadastros</a>
                                <ul class="submenu">

                                    @can('user-button')
                                    <li class="has-submenu">
                                        <a href="#">@lang('admin.include.users')</a>
                                        <ul class="submenu">
                                            @can('user-list')<li><a href="{{ route('admin.user.index') }}">@lang('admin.include.list_users')</a></li>@endcan
                                            @can('user-create')<li><a href="{{ route('admin.user.create') }}">@lang('admin.include.add_new_user')</a></li>@endcan
                                        </ul>
                                    </li>
                                    @endcan

                                    @can('provider-button')
                                    <li class="has-submenu">
                                        <a href="#">@lang('admin.include.providers')</a>
                                        <ul class="submenu">
                                            @can('provider-list')<li><a href="{{ route('admin.provider.index') }}">@lang('admin.include.list_providers')</a></li>@endcan
                                            @can('provider-create')<li><a href="{{ route('admin.provider.create') }}">@lang('admin.include.add_new_provider')</a></li>@endcan
                                        </ul>
                                    </li>
                                    @endcan

                                    @can('fleet-button')
                                    <li class="has-submenu">
                                        <a href="#">@lang('admin.include.fleet_owner')</a>
                                        <ul class="submenu">
                                            @can('fleet-list')<li><a href="{{ route('admin.fleet.index') }}">@lang('admin.include.list_fleets')</a></li>@endcan
                                            @can('fleet-create')<li><a href="{{ route('admin.fleet.create') }}">@lang('admin.include.add_new_fleet_owner')</a></li>@endcan
                                        </ul>
                                    </li>
                                    @endcan

                                    @can('documents-button')
                                    <li class="has-submenu">
                                        <a href="#">@lang('admin.include.documents')</a>
                                        <ul class="submenu">
                                            @can('documents-list')<li><a href="{{ route('admin.document.index') }}">@lang('admin.include.list_documents')</a></li>@endcan
                                            @can('documents-create')<li><a href="{{ route('admin.document.create') }}">@lang('admin.include.add_new_document')</a></li>@endcan
                                        </ul>
                                    </li>
                                    @endcan

                                    @can('cancel-reasons-button')
                                    <li class="has-submenu">
                                        <a href="#">Motivos .Cancel</a>
                                        <ul class="submenu">
                                            @can('cancel-reasons-list')<li><a href="{{ route('admin.reason.index') }}">@lang('admin.include.list_reasons')</a></li>@endcan
                                            @can('cancel-reasons-create')<li><a href="{{ route('admin.reason.create') }}">@lang('admin.include.add_new_reason')</a></li>@endcan
                                        </ul>
                                    </li>
                                    @endcan 

                                    
                                </ul>
                            </li>
                            @endcan

                            @can('financial-button')
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-finance"></i>Financeiro</a>
                                <ul class="submenu">
                                    @can('financial-overview')
                                    <li>
                                        <a href="{{ route('admin.financial.overview') }}">Visão Geral</a>
                                    </li>
                                    @endcan
                                    @can('financial-releases')
                                    <li>
                                        <a href="{{ route('admin.financial.realeses') }}">Lançamentos</a>
                                    </li>
                                    @endcan
                                    
                                </ul>
                            </li>
                            @endcan

                            @can('other-button')
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-format-list-bulleted"></i>Outros</a>
                                <ul class="submenu">
                                    @can('lost-item-list')
                                    <li><a href="{{ route('admin.lostitem.index') }}">Itens Perdidos</a></li>
                                    @endcan
                                    @can('other-reveiws')
                                    <li><a href="{{ route('admin.reviews') }}">Avaliações e Reviews</a></li>
                                    @endcan
                                    @can('cms-pages')
                                    <li><a href="{{ route('admin.cmspages') }}">Páginas Estáticas</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan

                            

                        </ul>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        