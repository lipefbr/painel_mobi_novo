<!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                    <div class="logo">
                        
                        <a href="{{url('admin/dashboard')}}" class="logo">
                            <img src="{{  setting('site_logo', config('constants.site_logo', asset('logo-black.png'))) }}" alt="" class="logo-small">
                            <img src="{{  setting('site_logo', config('constants.site_logo', asset('logo-black.png'))) }}" alt="" class="logo-large">
                        </a>

                    </div>

                    <!-- End Logo container-->


                    <div class="menu-extras topbar-custom">

                        <ul class="navbar-right d-flex list-inline float-right mb-0">
                            @can('god-eye')
                            <li class="notification-list">
                                <a class="nav-link arrow-none waves-effect waves-light" href="{{ route('admin.godseye') }}"  >
                                    <i class="mdi mdi-eye noti-icon" data-toggle="tooltip"  title="Mapa Olho de Deus"></i>
                                </a>
                            </li>
                            @endcan

                            @can('custom-push')
                            <li class="notification-list">
                                <a class="nav-link arrow-none waves-effect waves-light" href="{{ route('admin.push') }}" aria-haspopup="false">
                                    <i class="mdi mdi-comment-text noti-icon" data-toggle="tooltip" data-placement="bottom" title="Notificações"></i>
                                </a>
                            </li>
                            @endcan

                            <li class="dropdown notification-list">
                                <div class="dropdown notification-list">
                                    <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="{{img(Auth::guard('admin')->user()->picture)}}" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        @can('account-settings')
                                        <a class="dropdown-item" href="{{route('admin.profile')}}"><i class="mdi mdi-account-circle m-r-5"></i> @lang('admin.include.profile')</a>
                                        @endcan

                                        @can('settings')
                                        <a class="dropdown-item d-block" href="{{ route('admin.settings') }}"><i class="mdi mdi-settings m-r-5"></i> Configurações</a>
                                        @endcan

                                        @can('admin-user-view')
                                         <a class="dropdown-item d-block" href="{{ route('admin.acl.users') }}"><i class="mdi mdi-account-circle m-r-5"></i> Usuários</a>
                                        @endcan

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="{{ url('/admin/logout') }}"
                                    onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i> Sair</a>
                                    </div>                                                                    
                                </div>
                            </li>
                            
                            <li class="menu-item list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>
    
    
    
                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            @include('admin.layout.partials.menu')
        </header>