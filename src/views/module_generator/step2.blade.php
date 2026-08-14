@extends("crudbooster::admin_template")
@section("content")
    @push('head')
        <link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css")?>'/>
        <link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/adminlte4/css/adminlte-select2.min.css")?>'/>
        <style>
            .table-display tbody tr td {
                position: relative;
            }

            .sub {
                position: absolute;
                top: inherit;
                left: inherit;
                padding: 0;
                margin: 0;
                list-style-type: none;
                max-height: 180px;
                overflow-y: auto;
                z-index: 1050;
                border-radius: 4px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            }

            .sub li {
                padding: 6px 10px;
                background: var(--bs-secondary-bg, #343a40);
                color: var(--bs-body-color, #dee2e6);
                border: 1px solid var(--bs-border-color, #495057);
                cursor: pointer;
                display: block;
                width: 200px;
            }

            .sub li:hover {
                background: var(--bs-primary, #0d6efd);
                color: #ffffff;
            }

            .btn-drag {
                cursor: move;
            }
        </style>
    @endpush

    @push('bottom')
        <script src='<?php echo asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js")?>'></script>
        <script>
            $(function () {
                $('.select2').select2({ width: '100%' });
            })
        </script>
    @endpush

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep1')."/".$id}}"><i class='bi bi-info-circle me-1'></i> Step 1 - Module Information</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{Route('ModulsControllerGetStep2')."/".$id}}"><i class='bi bi-table me-1'></i> Step 2 - Table Display</a></li>
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep3')."/".$id}}"><i class='bi bi-plus-square me-1'></i> Step 3 - Form Display</a></li>
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep4')."/".$id}}"><i class='bi bi-gear me-1'></i> Step 4 - Configuration</a></li>
    </ul>

    @push('bottom')
        <script>
            var columns = {!! json_encode($columns) !!};
            var tables = {!! json_encode($table_list) !!};

            function ucwords(str) {
                return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                    return $1.toUpperCase();
                });
            }

            function showNameSuggest(t) {
                t = $(t);
                t.next("ul").remove();
                var list = '';
                $.each(columns, function (i, obj) {
                    list += "<li>" + obj + "</li>";
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showNameSuggestLike(t) {
                t = $(t);
                var v = t.val();
                t.next("ul").remove();
                if (!v) return false;

                var list = '';
                $.each(columns, function (i, obj) {
                    if (obj.includes(v.toLowerCase())) {
                        list += "<li>" + obj + "</li>";
                    }
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showColumnSuggest(t) {
                t = $(t);
                t.next("ul").remove();

                var list = '';
                $.each(columns, function (i, obj) {
                    obj = obj.replace('id_', '');
                    obj = ucwords(obj.replace('_', ' '));
                    list += "<li>" + obj + "</li>";
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showColumnSuggestLike(t) {
                t = $(t);
                var v = t.val();
                t.next("ul").remove();
                if (!v) return false;

                var list = '';
                $.each(columns, function (i, obj) {
                    if (obj.includes(v.toLowerCase())) {
                        obj = obj.replace('id_', '');
                        obj = ucwords(obj.replace('_', ' '));
                        list += "<li>" + obj + "</li>";
                    }
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showTable(t) {
                t = $(t);
                t.next("ul").remove();
                var list = '';
                $.each(tables, function (i, obj) {
                    list += "<li>" + obj + "</li>";
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showTableLike(t) {
                t = $(t);
                var v = t.val();
                t.next("ul").remove();
                if (!v) return false;

                var list = '';
                $.each(tables, function (i, obj) {
                    if (obj.includes(v.toLowerCase())) {
                        list += "<li>" + obj + "</li>";
                    }
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showTableFieldLike(t) {
                t = $(t);
                var table = t.parent().parent().find('.join_table').val();
                var v = t.val();

                t.next("ul").remove();
                if (!table) return false;
                if (!v) return false;

                t.after("<ul class='sub'><li><i class='bi bi-arrow-repeat spin'></i> Loading...</li></ul>");

                $.get("{{CRUDBooster::mainpath('table-columns')}}/" + table, function (response) {
                    t.next("ul").remove();
                    var list = '';
                    $.each(response, function (i, obj) {
                        if (obj.includes(v.toLowerCase())) {
                            list += "<li>" + obj + "</li>";
                        }
                    });
                    t.after("<ul class='sub'>" + list + "</ul>");
                });
            }

            function showTableField(t) {
                t = $(t);
                var table = t.parent().parent().find('.join_table').val();
                var v = t.val();

                if (!table) return false;

                t.after("<ul class='sub'><li><i class='bi bi-arrow-repeat spin'></i> Loading...</li></ul>");

                $.get("{{CRUDBooster::mainpath('table-columns')}}/" + table, function (response) {
                    t.next("ul").remove();
                    var list = '';
                    $.each(response, function (i, obj) {
                        list += "<li>" + obj + "</li>";
                    });
                    t.after("<ul class='sub'>" + list + "</ul>");
                });
            }

            $(function () {
                $(document).on('click', '.btn-plus', function () {
                    var tr_parent = $(this).parent().parent().parent('tr');
                    var clone = $('#tr-sample').clone();
                    clone.removeAttr('id');
                    tr_parent.after(clone);
                    $('.table-display tr').not('#tr-sample').show();
                })

                //init row
                $('.btn-plus').last().click();

                $(document).mouseup(function (e) {
                    var container = $(".sub");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        container.hide();
                    }
                });

                $(document).on('click', '.sub li', function () {
                    var v = $(this).text();
                    $(this).parent('ul').prev('input[type=text]').val(v);
                    $(this).parent('ul').remove();
                })

                $(document).on('click', '.table-display .btn-delete', function () {
                    $(this).parent().parent().parent().remove();
                })

                $(document).on('click', '.table-display .btn-up', function () {
                    var tr = $(this).parent().parent().parent();
                    var trPrev = tr.prev('tr');
                    if (trPrev.length != 0) {
                        tr.prev('tr').before(tr.clone());
                        tr.remove();
                    }
                })

                $(document).on('click', '.table-display .btn-down', function () {
                    var tr = $(this).parent().parent().parent();
                    var trPrev = tr.next('tr');
                    if (trPrev.length != 0) {
                        tr.next('tr').after(tr.clone());
                        tr.remove();
                    }
                })

                $(document).on('change', '.is_image', function () {
                    var tr = $(this).parent().parent();
                    if ($(this).val() == 1) {
                        tr.find('.is_download').val(0);
                    }
                })

                $(document).on('change', '.is_download', function () {
                    var tr = $(this).parent().parent();
                    if ($(this).val() == 1) {
                        tr.find('.is_image').val(0);
                    }
                })
            })
        </script>
    @endpush

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Table Display</h5>
        </div>
        <form method="post" action="{{Route('ModulsControllerPostStep3')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" value="{{$id}}">

            <div class="card-body">
                <div class="alert alert-info">
                    <strong><i class="bi bi-info-circle me-1"></i> Warning:</strong> Make sure that your column format is normal. Using this Tool may replace your existing configuration.
                </div>

                <div class="table-responsive">
                    <table class="table-display table table-striped table-bordered align-middle">
                        <thead>
                        <tr>
                            <th>Column</th>
                            <th>Name</th>
                            <th colspan='2'>Join (Optional)</th>
                            <th>CallbackPHP</th>
                            <th style="width: 100px;">Width (px)</th>
                            <th style="width: 80px;">Image</th>
                            <th style="width: 80px;">Download</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($cb_col)
                            @foreach($cb_col as $c)
                                <tr>
                                    <td><input value='{{@$c["label"]}}' type='text' name='column[]' onclick='showColumnSuggest(this)'
                                               onKeyUp='showColumnSuggestLike(this)' placeholder='Column Name' class='column form-control notfocus'/></td>
                                    <td><input value='{{@$c["name"]}}' type='text' name='name[]' onclick='showNameSuggest(this)' onKeyUp='showNameSuggestLike(this)'
                                               placeholder='Field Name' class='name form-control notfocus'/></td>
                                    <td><input value='{{ @explode(",",$c["join"])[0] }}' type='text' name='join_table[]' onclick='showTable(this)'
                                               onKeyUp='showTableLike(this)' placeholder='Table Name' class='join_table form-control notfocus'/></td>
                                    <td><input value='{{ @explode(",",$c["join"])[1] }}' type='text' name='join_field[]' onclick='showTableField(this)'
                                               onKeyUp='showTableFieldLike(this)' placeholder='Field Name Shown' class='join_field form-control notfocus'/>
                                    </td>
                                    <td><input type='text' name='callbackphp[]' class='form-control callbackphp notfocus' value='{{@$c["callback_php"]}}'
                                               placeholder="Optional"/></td>
                                    <td><input value='{{@$c["width"]?:0}}' type='number' name='width[]' class='form-control'/></td>
                                    <td>
                                        <select class='form-select is_image' name='is_image[]'>
                                            <option {{ (!@$c['image'])?"selected":""}} value='0'>N</option>
                                            <option {{ (@$c['image'])?"selected":""}} value='1'>Y</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-select is_download' name='is_download[]'>
                                            <option {{ (!@$c['download'])?"selected":""}} value='0'>N</option>
                                            <option {{ (@$c['download'])?"selected":""}} value='1'>Y</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="javascript:void(0)" class="btn btn-outline-info btn-plus" title="Add Row"><i class='bi bi-plus-lg'></i></a>
                                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-delete" title="Delete Row"><i class='bi bi-trash'></i></a>
                                            <a href="javascript:void(0)" class="btn btn-outline-success btn-up" title="Move Up"><i class='bi bi-arrow-up'></i></a>
                                            <a href="javascript:void(0)" class="btn btn-outline-success btn-down" title="Move Down"><i class='bi bi-arrow-down'></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <tr id="tr-sample" style="display:none">
                            <td><input type='text' name='column[]' onclick='showColumnSuggest(this)' onKeyUp='showColumnSuggestLike(this)' placeholder='Column Name'
                                       class='column form-control notfocus'/></td>
                            <td><input type='text' name='name[]' onclick='showNameSuggest(this)' onKeyUp='showNameSuggestLike(this)' placeholder='Field Name'
                                       class='name form-control notfocus'/></td>
                            <td><input type='text' name='join_table[]' onclick='showTable(this)' onKeyUp='showTableLike(this)' placeholder='Table Name'
                                       class='join_table form-control notfocus'/></td>
                            <td><input type='text' name='join_field[]' onclick='showTableField(this)' onKeyUp='showTableFieldLike(this)'
                                       placeholder='Field Name Shown' class='join_field form-control notfocus'/></td>
                            <td><input type='text' name='callbackphp[]' class='form-control callbackphp notfocus' placeholder="Optional"/></td>
                            <td><input type='number' name='width[]' value='0' class='form-control'/></td>
                            <td>
                                <select class='form-select is_image' name='is_image[]'>
                                    <option value='0'>N</option>
                                    <option value='1'>Y</option>
                                </select>
                            </td>
                            <td>
                                <select class='form-select is_download' name='is_download[]'>
                                    <option value='0'>N</option>
                                    <option value='1'>Y</option>
                                </select>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="javascript:void(0)" class="btn btn-outline-info btn-plus" title="Add Row"><i class='bi bi-plus-lg'></i></a>
                                    <a href="javascript:void(0)" class="btn btn-outline-danger btn-delete" title="Delete Row"><i class='bi bi-trash'></i></a>
                                    <a href="javascript:void(0)" class="btn btn-outline-success btn-up" title="Move Up"><i class='bi bi-arrow-up'></i></a>
                                    <a href="javascript:void(0)" class="btn btn-outline-success btn-down" title="Move Down"><i class='bi bi-arrow-down'></i></a>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="button" onclick="location.href='{{CRUDBooster::mainpath('step1').'/'.$id}}'" class="btn btn-outline-secondary">&laquo; Back</button>
                <input type="submit" class="btn btn-primary" value="Step 3 &raquo;">
            </div>
        </form>
    </div>

@endsection