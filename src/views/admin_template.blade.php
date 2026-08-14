<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ (!empty($page_title)) ? CRUDBooster::getSetting('appname').': '.strip_tags($page_title) : "Admin Area" }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name='generator' content='CRUDBooster {{ \crocodicstudio\crudbooster\commands\CrudboosterVersionCommand::$version }}'/>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon"
          href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    
    <!-- Font Awesome Icons -->
    <link href="{{asset("vendor/crudbooster/assets/adminlte/font-awesome/css")}}/font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />

    <!-- AdminLTE 4 CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/crudbooster/assets/adminlte4/css/adminlte.min.css') }}" />

    <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/main.css") }}'/>

    <style type="text/css">
        @if(isset($style_css) && $style_css)
            {!! $style_css !!}
        @endif
    </style>
    @if(isset($load_css) && $load_css)
        @foreach($load_css as $css)
            <link href="{{$css}}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

    @stack('head')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- Header -->
    @include('crudbooster::header')

    <!-- Sidebar -->
    @include('crudbooster::sidebar')

    <!-- Main Content Wrapper -->
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <?php $module = CRUDBooster::getCurrentModule(); ?>
                        <h3 class="mb-0">
                            @if($module)
                                <i class='{!! isset($page_icon)?$page_icon:$module->icon !!}'></i> {!! ucwords(isset($page_title)?$page_title:$module->name) !!}
                            @else
                                {{Session::get('appname')}}
                            @endif
                        </h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-end">
                            @if(CRUDBooster::getCurrentMethod() == 'getIndex')
                                @if(isset($button_show) && $button_show)
                                    <a href="{{ CRUDBooster::mainpath().'?'.http_build_query(Request::all()) }}" id='btn_show_data' class="btn btn-sm btn-primary me-1" title="{{cbLang('action_show_data')}}">
                                        <i class="bi bi-table"></i> {{cbLang('action_show_data')}}
                                    </a>
                                @endif

                                @if(isset($button_add) && $button_add && CRUDBooster::isCreate())
                                    <a href="{{ CRUDBooster::mainpath('add').'?return_url='.urlencode(Request::fullUrl()).'&parent_id='.g('parent_id').'&parent_field='.@$parent_field }}"
                                       id='btn_add_new_data' class="btn btn-sm btn-success me-1" title="{{cbLang('action_add_data')}}">
                                        <i class="bi bi-plus-circle"></i> {{cbLang('action_add_data')}}
                                    </a>
                                @endif
                            @endif

                            @if(isset($button_export) && $button_export && CRUDBooster::getCurrentMethod() == 'getIndex')
                                <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='{{@$build_query}}' title='Export Data'
                                   class="btn btn-sm btn-primary btn-export-data me-1">
                                    <i class="bi bi-upload"></i> {{cbLang("button_export")}}
                                </a>
                            @endif

                            @if(isset($button_import) && $button_import && CRUDBooster::getCurrentMethod() == 'getIndex')
                                <a href="{{ CRUDBooster::mainpath('import-data') }}" id='btn_import_data' data-url-parameter='{{@$build_query}}' title='Import Data'
                                   class="btn btn-sm btn-primary btn-import-data me-1">
                                    <i class="bi bi-download"></i> {{cbLang("button_import")}}
                                </a>
                            @endif

                            @if(!empty($index_button))
                                @foreach($index_button as $ib)
                                    <a href='{{$ib["url"]}}' id='{{\Illuminate\Support\Str::slug($ib["label"])}}' class='btn {{(@$ib['color'])?'btn-'.@$ib['color']:'btn-primary'}} btn-sm me-1'>
                                        <i class='{{$ib["icon"]}}'></i> {{$ib["label"]}}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(@$alerts)
                    @foreach(@$alerts as $alert)
                        <div class='callout callout-{{$alert["type"]}} mb-3'>
                            {!! $alert['message'] !!}
                        </div>
                    @endforeach
                @endif

                @if (Session::get('message')!='')
                    <div class='alert alert-{{ Session::get("message_type") }} alert-dismissible fade show' role="alert">
                        <h4><i class="icon bi bi-info-circle"></i> {{ cbLang("alert_".Session::get("message_type")) }}</h4>
                        {!!Session::get('message')!!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('crudbooster::footer')

</div>

@include('crudbooster::admin_template_plugins')

@if(isset($load_js) && $load_js)
    @foreach($load_js as $js)
        <script src="{{$js}}"></script>
    @endforeach
@endif
<script type="text/javascript">
    var site_url = "{{url('/')}}";
    @if(isset($script_js) && $script_js)
        {!! $script_js !!}
    @endif
</script>

@stack('bottom')
</body>
</html>
