@extends('crudbooster::admin_template')
@section('content')

    @push('head')
        <style type="text/css">
            body.dragging, body.dragging * {
                cursor: move !important;
            }

            .dragged {
                position: absolute;
                opacity: 0.7;
                z-index: 2000;
            }

            .draggable-menu {
                padding: 0 0 0 0;
                margin: 0 0 0 0;
            }

            .draggable-menu li ul {
                margin-top: 6px;
                padding-left: 20px;
            }

            .draggable-menu li div {
                padding: 10px;
                border: 1px solid var(--bs-border-color, #495057);
                background: var(--bs-secondary-bg, #2b3035);
                color: var(--bs-body-color, #e0e0e0);
                border-radius: 6px;
                cursor: move;
            }

            .draggable-menu li div a {
                color: var(--bs-body-color, #e0e0e0);
            }

            .draggable-menu li .is-dashboard {
                background: var(--bs-warning-bg-subtle, rgba(255, 193, 7, 0.15));
                border-color: var(--bs-warning-border-subtle, #ffc107);
            }

            .draggable-menu li .icon-is-dashboard {
                color: #ffb600;
            }

            .draggable-menu li {
                list-style-type: none;
                margin-bottom: 6px;
                min-height: 35px;
            }

            .draggable-menu li.placeholder {
                position: relative;
                border: 1px dashed var(--bs-danger, #dc3545);
                background: var(--bs-tertiary-bg, #212529);
            }
        </style>
    @endpush

    @push('bottom')
        <script type="text/javascript">
            $(function () {
                function format(icon) {
                    var originalOption = icon.element;
                    var label = $(originalOption).text();
                    var val = $(originalOption).val();
                    if (!val) return label;
                    var $resp = $('<span><i style="margin-top:5px" class="float-end ' + $(originalOption).val() + '"></i> ' + $(originalOption).data('label') + '</span>');
                    return $resp;
                }

                $('#list-icon').select2({
                    width: "100%",
                    templateResult: format,
                    templateSelection: format
                });
            })
        </script>
    @endpush
    @push('bottom')
        <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script>
        <script type="text/javascript">
            $(function () {
                var id_cms_privileges = '{{$id_cms_privileges}}';
                var sortactive = $(".draggable-menu").sortable({
                    group: '.draggable-menu',
                    delay: 200,
                    isValidTarget: function ($item, container) {
                        var depth = 1,
                            maxDepth = 2,
                            children = $item.find('ul').first().find('li');

                        depth += container.el.parents('ul').length;

                        while (children.length) {
                            depth++;
                            children = children.find('ul').first().find('li');
                        }

                        return depth <= maxDepth;
                    },
                    onDrop: function ($item, container, _super) {

                        if ($item.parents('ul').hasClass('draggable-menu-active')) {
                            var isActive = 1;
                            var data = $('.draggable-menu-active').sortable("serialize").get();
                            var jsonString = JSON.stringify(data, null, ' ');
                        } else {
                            var isActive = 0;
                            var data = $('.draggable-menu-inactive').sortable("serialize").get();
                            var jsonString = JSON.stringify(data, null, ' ');
                            $('#inactive_text').remove();
                        }

                        $.post("{{route('MenusControllerPostSaveMenu')}}", {menus: jsonString, isActive: isActive}, function (resp) {
                            $('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
                        });

                        _super($item, container);
                    }
                });


            });
        </script>
    @endpush

    <div class='row g-3'>
        <div class="col-md-5">

            <div class="card mb-3">
                <div class="card-header text-bg-success">
                    <strong class="card-title mb-0">Menu Order (Active)</strong>
                    <span id='menu-saved-info' style="display:none" class='float-end text-white'><i class='bi bi-check-lg'></i> Menu Saved !</span>
                </div>
                <div class="card-body">
                    <ul class='draggable-menu draggable-menu-active'>
                        @foreach($menu_active as $menu)
                            @php
                                $privileges = DB::table('cms_menus_privileges')
                                ->join('cms_privileges','cms_privileges.id','=','cms_menus_privileges.id_cms_privileges')
                                ->where('id_cms_menus',$menu->id)->pluck('cms_privileges.name')->toArray();
                            @endphp
                            <li data-id='{{$menu->id}}' data-name='{{$menu->name}}'>
                                <div class='{{$menu->is_dashboard?"is-dashboard":""}}' title="{{$menu->is_dashboard?'This is set as Dashboard':''}}">
                                    <i class='{{($menu->is_dashboard)?"icon-is-dashboard bi bi-speedometer2":$menu->icon}}'></i> <strong>{{$menu->name}}</strong>
                                    <span class='float-end'>
                                        <a class='bi bi-pencil me-1' title='Edit' href='{{route("MenusControllerGetEdit")."/".$menu->id }}?return_url={{urlencode(Request::fullUrl())}}'></a>
                                        <a title='Delete' class='bi bi-trash text-danger' onclick='{{CRUDBooster::deleteConfirm(route("MenusControllerGetDelete") ."/".$menu->id) }}' href='javascript:void(0)'></a>
                                    </span>
                                    <br/><em class="text-secondary">
                                        <small><i class="bi bi-people"></i> &nbsp; {{implode(', ',$privileges)}}</small>
                                    </em>
                                </div>
                                <ul>
                                    @if(@$menu->children)
                                        @foreach($menu->children as $child)
                                            @php
                                                $privileges = DB::table('cms_menus_privileges')
                                                ->join('cms_privileges','cms_privileges.id','=','cms_menus_privileges.id_cms_privileges')
                                                ->where('id_cms_menus',$child->id)->pluck('cms_privileges.name')->toArray();
                                            @endphp
                                            <li data-id='{{$child->id}}' data-name='{{$child->name}}'>
                                                <div class='{{$child->is_dashboard?"is-dashboard":""}}'
                                                     title="{{$child->is_dashboard?'This is set as Dashboard':''}}">
                                                    <i class='{{($child->is_dashboard)?"icon-is-dashboard bi bi-speedometer2":$child->icon}}'></i> {{$child->name}}
                                                    <span class='float-end'>
                                                        <a class='bi bi-pencil me-1' title='Edit' href='{{ route("MenusControllerGetEdit") ."/".$child->id }}?return_url={{urlencode(Request::fullUrl())}}'></a>
                                                        <a title="Delete" class='bi bi-trash text-danger' onclick='{{CRUDBooster::deleteConfirm(route("MenusControllerGetDelete") . "/". $child->id) }}' href='javascript:void(0)'></a>
                                                    </span>
                                                    <br/><em class="text-secondary">
                                                        <small><i class="bi bi-people"></i> &nbsp; {{implode(', ',$privileges)}}</small>
                                                    </em>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                    @if(count($menu_active)==0)
                        <div class="text-center text-secondary">Active menu is empty, please add new menu</div>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header text-bg-danger">
                    <strong class="card-title mb-0">Menu Order (Inactive)</strong>
                </div>
                <div class="card-body">
                    <ul class='draggable-menu draggable-menu-inactive'>
                        @foreach($menu_inactive as $menu)
                            <li data-id='{{$menu->id}}' data-name='{{$menu->name}}'>
                                <div><i class='{{$menu->icon}}'></i> {{$menu->name}}
                                    <span class='float-end'>
                                        <a class='bi bi-pencil me-1' title='Edit' href='{{route("MenusControllerGetEdit",["id"=>$menu->id])}}?return_url={{urlencode(Request::fullUrl())}}'></a>
                                        <a title='Delete' class='bi bi-trash text-danger' onclick='{{CRUDBooster::deleteConfirm(route("MenusControllerGetDelete",["id"=>$menu->id]))}}' href='javascript:void(0)'></a>
                                    </span>
                                </div>
                                <ul>
                                    @if(@$menu->children)
                                        @foreach($menu->children as $child)
                                            <li data-id='{{$child->id}}' data-name='{{$child->name}}'>
                                                <div><i class='{{$child->icon}}'></i> {{$child->name}}
                                                    <span class='float-end'>
                                                        <a class='bi bi-pencil me-1' title='Edit' href='{{route("MenusControllerGetEdit",["id"=>$child->id])}}?return_url={{urlencode(Request::fullUrl())}}'></a>
                                                        <a title="Delete" class='bi bi-trash text-danger' onclick='{{CRUDBooster::deleteConfirm(route("MenusControllerGetDelete",["id"=>$child->id]))}}' href='javascript:void(0)'></a>
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                    @if(count($menu_inactive)==0)
                        <div class="text-center text-secondary" id='inactive_text'>Inactive menu is empty</div>
                    @endif
                </div>
            </div>


        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-bg-primary">
                    <strong class="card-title mb-0">Add Menu</strong>
                </div>
                <div class="card-body">
                    <form method='post' id="form" enctype="multipart/form-data" action='{{CRUDBooster::mainpath("add-save")}}'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type='hidden' name='return_url' value='{{Request::fullUrl()}}'/>
                        @include("crudbooster::default.form_body")
                        <div class="d-flex justify-content-end mt-3">
                            <input type='submit' class='btn btn-primary' value='Add Menu'/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection