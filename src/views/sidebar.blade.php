<aside class="app-sidebar shadow">
    <div class="sidebar-brand">
        <a href="{{url(config('crudbooster.ADMIN_PATH'))}}" class="brand-link">
            <img src="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}" alt="Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{CRUDBooster::getSetting('appname')}}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <?php $dashboard = CRUDBooster::sidebarDashboard();?>
                @if($dashboard)
                    <li class="nav-item">
                        <a href='{{CRUDBooster::adminPath()}}' class="nav-link {{ (Request::is(config('crudbooster.ADMIN_PATH'))) ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>{{cbLang("text_dashboard")}}</p>
                        </a>
                    </li>
                @endif

                @foreach(CRUDBooster::sidebarMenu() as $menu)
                    <li class="nav-item {{(!empty($menu->children))?"menu-open":""}}">
                        <a href='{{ ($menu->is_broken)?"javascript:alert('".cbLang('controller_route_404')."')":$menu->url }}' class="nav-link {{ (Request::is($menu->url_path."*"))?"active":""}}">
                            <i class="nav-icon {{ $menu->icon ?: 'bi bi-circle' }}"></i>
                            <p>
                                {{$menu->name}}
                                @if(!empty($menu->children))
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                @endif
                            </p>
                        </a>
                        @if(!empty($menu->children))
                            <ul class="nav nav-treeview">
                                @foreach($menu->children as $child)
                                    <li class="nav-item">
                                        <a href='{{ ($child->is_broken)?"javascript:alert('".cbLang('controller_route_404')."')":$child->url}}' class="nav-link {{(Request::is($child->url_path .= !Str::endsWith(Request::decodedPath(), $child->url_path) ? "/*" : ""))?"active":""}}">
                                            <i class="nav-icon {{ $child->icon ?: 'bi bi-circle' }}"></i>
                                            <p>{{$child->name}}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

                @if(CRUDBooster::isSuperadmin())
                    <li class="nav-header">{{ cbLang('SUPERADMIN') }}</li>
                    <li class='nav-item'>
                        <a href='#' class="nav-link"><i class='nav-icon bi bi-key-fill'></i> <p>{{ cbLang('Privileges_Roles') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class='nav nav-treeview'>
                            <li class="nav-item"><a href='{{Route("PrivilegesControllerGetAdd")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('Add_New_Privilege') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("PrivilegesControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-ul'></i> <p>{{ cbLang('List_Privilege') }}</p></a></li>
                        </ul>
                    </li>

                    <li class='nav-item'>
                        <a href='#' class="nav-link"><i class='nav-icon bi bi-people-fill'></i> <p>{{ cbLang('Users_Management') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class='nav nav-treeview'>
                            <li class="nav-item"><a href='{{Route("AdminCmsUsersControllerGetAdd")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('add_user') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("AdminCmsUsersControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-ul'></i> <p>{{ cbLang('List_users') }}</p></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href='{{Route("MenusControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-nested'></i> <p>{{ cbLang('Menu_Management') }}</p></a></li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class='nav-icon bi bi-gear-fill'></i> <p>{{ cbLang('settings') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href='{{route("SettingsControllerGetAdd")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('Add_New_Setting') }}</p></a></li>
                            <?php
                            $groupSetting = DB::table('cms_settings')->groupby('group_setting')->pluck('group_setting');
                            foreach($groupSetting as $gs):
                            ?>
                            <li class="nav-item"><a href='{{route("SettingsControllerGetShow")}}?group={{urlencode($gs)}}&m=0' class="nav-link"><i class='nav-icon bi bi-gear'></i> <p>{{$gs}}</p></a></li>
                            <?php endforeach;?>
                        </ul>
                    </li>

                    <li class='nav-item'>
                        <a href='#' class="nav-link"><i class='nav-icon bi bi-boxes'></i> <p>{{ cbLang('Module_Generator') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class='nav nav-treeview'>
                            <li class="nav-item"><a href='{{Route("ModulsControllerGetStep1")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('Add_New_Module') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("ModulsControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-ul'></i> <p>{{ cbLang('List_Module') }}</p></a></li>
                        </ul>
                    </li>

                    <li class='nav-item'>
                        <a href='#' class="nav-link"><i class='nav-icon bi bi-graph-up-arrow'></i> <p>{{ cbLang('Statistic_Builder') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class='nav nav-treeview'>
                            <li class="nav-item"><a href='{{Route("StatisticBuilderControllerGetAdd")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('Add_New_Statistic') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("StatisticBuilderControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-ul'></i> <p>{{ cbLang('List_Statistic') }}</p></a></li>
                        </ul>
                    </li>

                    <li class='nav-item'>
                        <a href='#' class="nav-link"><i class='nav-icon bi bi-code-slash'></i> <p>{{ cbLang('API_Generator') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class='nav nav-treeview'>
                            <li class="nav-item"><a href='{{Route("ApiCustomControllerGetGenerator")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('Add_New_API') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("ApiCustomControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-ul'></i> <p>{{ cbLang('list_API') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("ApiCustomControllerGetScreetKey")}}' class="nav-link"><i class='nav-icon bi bi-key'></i> <p>{{ cbLang('Generate_Screet_Key') }}</p></a></li>
                        </ul>
                    </li>

                    <li class='nav-item'>
                        <a href='#' class="nav-link"><i class='nav-icon bi bi-envelope-at'></i> <p>{{ cbLang('Email_Templates') }} <i class="nav-arrow bi bi-chevron-right"></i></p></a>
                        <ul class='nav nav-treeview'>
                            <li class="nav-item"><a href='{{Route("EmailTemplatesControllerGetAdd")}}' class="nav-link"><i class='nav-icon bi bi-plus-lg'></i> <p>{{ cbLang('Add_New_Email') }}</p></a></li>
                            <li class="nav-item"><a href='{{Route("EmailTemplatesControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-list-ul'></i> <p>{{ cbLang('List_Email_Template') }}</p></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href='{{Route("LogsControllerGetIndex")}}' class="nav-link"><i class='nav-icon bi bi-journal-text'></i> <p>{{ cbLang('Log_User_Access') }}</p></a></li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
