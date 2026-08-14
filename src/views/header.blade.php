<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" title='Notifications'>
                    <i id='icon_notification' class="bi bi-bell"></i>
                    <span id='notification_count' class="navbar-badge badge text-bg-danger" style="display:none">0</span>
                </a>
                <div id='list_notifications' class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">{{cbLang("text_no_notification")}}</span>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('NotificationsControllerGetIndex')}}" class="dropdown-item dropdown-footer">{{cbLang("text_view_all_notification")}}</a>
                </div>
            </li>

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ CRUDBooster::myPhoto() }}" class="user-image rounded-circle shadow" alt="User Image"/>
                    <span class="d-none d-md-inline">{{ CRUDBooster::myName() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ CRUDBooster::myPhoto() }}" class="rounded-circle shadow" alt="User Image"/>
                        <p>
                            {{ CRUDBooster::myName() }}
                            <small>{{ CRUDBooster::myPrivilegeName() }}</small>
                            <small><em><?php echo date('d F Y')?></em></small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ route('AdminCmsUsersControllerGetProfile') }}" class="btn btn-outline-secondary"><i class='bi bi-person'></i> {{cbLang("label_button_profile")}}</a>
                        <a title='Lock Screen' href="{{ route('getLockScreen') }}" class='btn btn-outline-secondary'><i class='bi bi-key'></i></a>
                        <a href="javascript:void(0)" onclick="swal({
                                title: '{{cbLang('alert_want_to_logout')}}',
                                type:'info',
                                showCancelButton:true,
                                allowOutsideClick:true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: '{{cbLang('button_logout')}}',
                                cancelButtonText: '{{cbLang('button_cancel')}}',
                                closeOnConfirm: false
                                }, function(){
                                location.href = '{{ route("getLogout") }}';
                                });" title="{{cbLang('button_logout')}}" class="btn btn-outline-danger float-end"><i class='bi bi-power'></i></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
