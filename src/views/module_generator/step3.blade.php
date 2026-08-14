@extends("crudbooster::admin_template")
@section("content")
    @push('head')
        <link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css")?>'/>
        <link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/adminlte4/css/adminlte-select2.min.css")?>'/>
        <style>
            .table-form tbody tr td {
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
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep2')."/".$id}}"><i class='bi bi-table me-1'></i> Step 2 - Table Display</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{Route('ModulsControllerGetStep3')."/".$id}}"><i class='bi bi-plus-square me-1'></i> Step 3 - Form Display</a></li>
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep4')."/".$id}}"><i class='bi bi-gear me-1'></i> Step 4 - Configuration</a></li>
    </ul>

    @push('bottom')
        <script type="text/javascript">
            var columns = {!! json_encode($columns) !!};
            var types = {!! json_encode($types) !!};
            var validation_rules = ['required', 'string', 'integer', 'double', 'image', 'date', 'numeric', 'alpha_spaces'];

            function ucwords(str) {
                return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                    return $1.toUpperCase();
                });
            }

            function showTypeSuggest(t) {
                t = $(t);
                t.next("ul").remove();
                var list = '';
                $.each(types, function (i, obj) {
                    list += "<li>" + obj + "</li>";
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showTypeSuggestLike(t) {
                t = $(t);
                var v = t.val();
                t.next("ul").remove();
                if (!v) return false;

                var list = '';
                $.each(types, function (i, obj) {
                    if (obj.includes(v.toLowerCase())) {
                        list += "<li>" + obj + "</li>";
                    }
                });
                t.after("<ul class='sub'>" + list + "</ul>");
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

            function showValidationSuggest(t) {
                t = $(t);
                t.next("ul").remove();
                var list = '';
                $.each(validation_rules, function (i, obj) {
                    list += "<li>" + obj + "</li>";
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            function showValidationSuggestLike(t) {
                t = $(t);
                var v = t.val();
                t.next("ul").remove();
                if (!v) return false;

                var list = '';
                $.each(validation_rules, function (i, obj) {
                    if (obj.includes(v.toLowerCase())) {
                        list += "<li>" + obj + "</li>";
                    }
                });
                t.after("<ul class='sub'>" + list + "</ul>");
            }

            $(function () {
                $(document).on('click', '.btn-plus', function () {
                    var tr_parent = $(this).parent().parent().parent('tr');
                    var clone = $('#tr-sample').clone();
                    clone.removeAttr('id');
                    tr_parent.after(clone);
                    $('.table-form tr').not('#tr-sample').show();
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
                    var t = $(this).parent('ul').parent('td');
                    var tr_index = parseInt(t.parent().index());

                    var input_name = $(this).parent().parent('td').find('input[type=text]').attr('name');

                    if (input_name == 'type[]') {
                        $(this).parent('ul').prev('input[type=text]').val(v);
                        $(this).parent('ul').remove();

                        t.parent('tr').find('.option_area').empty();

                        $.getJSON("{{CRUDBooster::mainpath('type-info')}}/" + v, function (data) {
                            if (data.alert) {
                                t.parent('tr').find('.option_area').prepend("<div class='alert alert-warning'><strong>IMPORTANT</strong><br/>" + data.alert + "</div>");
                            }

                            if (data.attribute.required) {
                                $.each(data.attribute.required, function (key, val) {
                                    var form_group_html = '';
                                    if (val instanceof Object) {
                                        form_group_html += "<div class='mb-3'><label class='form-label fw-bold'>" + key + "</label>";
                                        if (val.type) {
                                            if (val.type == 'radio') {
                                                $.each(val.enum, function (i, o) {
                                                    form_group_html += "<div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='option[" + tr_index + "][" + key + "]' value='" + o + "'/> <label class='form-check-label'>" + o + "</label></div> &nbsp;&nbsp;";
                                                })
                                            } else {
                                                if (val.type == 'array') {
                                                    form_group_html += "<input class='form-control required' name='option[" + tr_index + "][" + key + "]' placeholder='" + val.placeholder + "' type='text'/>";
                                                    form_group_html += "<input name='option[" + tr_index + "][" + key + "_type]' value='array' type='hidden'/>";
                                                } else {
                                                    form_group_html += "<input class='form-control required' name='option[" + tr_index + "][" + key + "]' placeholder='" + val.placeholder + "' type='text'/>";
                                                }
                                            }
                                        } else {
                                            form_group_html += "<input class='form-control required' name='option[" + tr_index + "][" + key + "]' placeholder='" + val + "' type='text'/>";
                                        }
                                        form_group_html += "</div>";
                                    } else {
                                        form_group_html +=
                                            "<div class='mb-3'>" +
                                            "<label class='form-label fw-bold'>" + key + "</label>" +
                                            "<input class='form-control required' name='option[" + tr_index + "][" + key + "]' placeholder='" + val + "' type='text'/>" +
                                            "</div>";
                                    }
                                    t.parent('tr').find('.option_area').append(form_group_html);
                                });
                            }

                            if (data.attribute.requiredOne) {
                                $.each(data.attribute.requiredOne, function (key, val) {
                                    t.parent('tr').find('.option_area').append(
                                        "<div class='mb-3'>" +
                                        "<label class='form-label fw-bold'>" + key + "</label>" +
                                        "<input class='form-control required-one' name='option[" + tr_index + "][" + key + "]' placeholder='" + val + "' type='text'/>" +
                                        "</div>"
                                    );
                                });
                            }

                            if (data.attribute.optional) {
                                $.each(data.attribute.optional, function (key, val) {
                                    if (typeof(val) == "object") {
                                        if (val.type == 'textarea') {
                                            t.parent('tr').find('.option_area').append(
                                                "<div class='mb-3'>" +
                                                "<label class='form-label fw-bold'>" + key + "</label>" +
                                                "<textarea class='form-control' name='option[" + tr_index + "][" + key + "]' placeholder='" + val.placeholder + "' ></textarea>" +
                                                "</div>"
                                            );
                                        }
                                    } else {
                                        t.parent('tr').find('.option_area').append(
                                            "<div class='mb-3'>" +
                                            "<label class='form-label fw-bold'>" + key + "</label>" +
                                            "<input class='form-control' name='option[" + tr_index + "][" + key + "]' placeholder='" + val + "' type='text'/>" +
                                            "</div>"
                                        );
                                    }
                                });
                            }
                        })
                    } else if (input_name == 'validation[]') {
                        var currentVal = $(this).parent('ul').prev('input[type=text]').val();
                        if (currentVal != '') {
                            v = currentVal + '|' + v;
                        }
                        $(this).parent('ul').prev('input[type=text]').val(v);
                        $(this).parent('ul').remove();
                    } else {
                        $(this).parent('ul').prev('input[type=text]').val(v);
                        $(this).parent('ul').remove();
                    }
                })

                $(document).on('click', '.table-form .btn-delete', function () {
                    $(this).parent().parent().parent().remove();
                })

                $(document).on('click', '.table-form .btn-up', function () {
                    var tr = $(this).parent().parent().parent();
                    var trPrev = tr.prev('tr');
                    if (trPrev.length != 0) {
                        tr.prev('tr').before(tr.clone());
                        tr.remove();
                    }
                })

                $(document).on('click', '.table-form .btn-down', function () {
                    var tr = $(this).parent().parent().parent();
                    var trPrev = tr.next('tr');
                    if (trPrev.length != 0) {
                        tr.next('tr').after(tr.clone());
                        tr.remove();
                    }
                })

                var current_option_area = null;

                $(document).on('click', '.btn-options', function () {
                    $('#myModal .modal-body').empty();
                    current_option_area = $(this).next('.option_area');

                    var clone = $(this).next('.option_area').clone();
                    clone.removeAttr('style');
                    clone.appendTo('#myModal .modal-body');

                    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
                    myModal.show();
                })

                $('#myModal .btn-save-option').click(function () {
                    var i_required = [];
                    $('#myModal .modal-body .required').each(function () {
                        var value = $(this).val();
                        var name = $(this).attr('name');
                        if (value == '') {
                            i_required.push(name);
                        }
                    });

                    if (i_required.length > 0) {
                        alert("Some these fields are required : " + i_required.join(", "));
                        return false;
                    }

                    var i_required_one = [];
                    $('#myModal .modal-body .required-one').each(function () {
                        var value = $(this).val();
                        var name = $(this).attr('name');
                        if (value == '') {
                            i_required_one.push(name);
                        }
                    })

                    if (i_required_one.length > 0 && i_required_one.length == $('#myModal .modal-body .required-one').length) {
                        alert("One of these fields are required : " + i_required_one.join(", "));
                        return false;
                    }

                    current_option_area.empty();
                    var clone = $('#myModal .option_area').children().clone();
                    current_option_area.html(clone);
                    $('#myModal .modal-body').empty();

                    var modalEl = document.getElementById('myModal');
                    var modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();
                })
            })
        </script>
    @endpush

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class='bi bi-gear me-1'></i> Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Loading options&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn-save-option btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Display</h5>
        </div>
        <form method="post" autocomplete="off" action="{{Route('ModulsControllerPostStep4')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" value="{{$id}}">

            <div class="card-body">
                <div class="table-responsive">
                    <table class='table-form table table-striped table-bordered align-middle'>
                        <thead>
                        <tr>
                            <th>Label</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Validation</th>
                            <th style="width: 100px;">Width</th>
                            <th style="width: 110px;">Options</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $index = 0;?>
                        @foreach($cb_form as $form)
                            <tr>
                                <td><input type='text' value='{{@$form["label"]}}' placeholder="Input field label" onclick='showColumnSuggest(this)'
                                           onkeyup="showColumnSuggestLike(this)" class='form-control labels' name='label[]'/></td>
                                <td><input type='text' value='{{@$form["name"]}}' placeholder="Input field name" onclick='showNameSuggest(this)'
                                           onkeyup="showNameSuggestLike(this)" class='form-control name' name='name[]'/></td>
                                <td><input type='text' value='{{@$form["type"]?:"text"}}' placeholder="Input field type" onclick='showTypeSuggest(this)'
                                           onkeyup="showTypeSuggestLike(this)" class='form-control type' name='type[]'/></td>
                                <td><input type='text' value='{{@$form["validation"]}}' class='form-control validation' onclick="showValidationSuggest(this)"
                                           onkeyup="showValidationSuggestLike(this)" name='validation[]' placeholder='Enter Laravel Validation'/>
                                </td>
                                <td>
                                    <select class='form-select width' name='width[]'>
                                        @for($i=10;$i>=1;$i--)
                                            <option {{ (@$form['width'] == "col-sm-$i")?"selected":"" }} value='col-sm-{{$i}}'>{{$i}}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <a class='btn btn-sm btn-outline-primary btn-options' href='javascript:;'><i class='bi bi-gear'></i> Options</a>
                                    <div class='option_area' style="display: none">
                                        <?php
                                        $type = $form["type"] ?: "text";
                                        $typesPath = __DIR__.'/../default/type_components/'.$type.'/info.json';
                                        $types = file_exists($typesPath) ? json_decode(file_get_contents($typesPath)) : null;

                                        if($types):
                                        ?>

                                        @if(@$types->alert)
                                            <div class="alert alert-warning">
                                                {!! $types->alert !!}
                                            </div>
                                        @endif

                                        <?php
                                        if(@$types->attribute->required):
                                        foreach($types->attribute->required as $key=>$val):
                                        @$value = $form[$key];
                                        if(is_object($val)):

                                        if(@$val->type && @$val->type == 'radio'):
                                        ?>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{$key}}</label>
                                            @foreach($val->enum as $enum)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="option[{{$index}}][{{$key}}]"
                                                           {{ ($enum == $value)?"checked":"" }} value="{{$enum}}">
                                                    <label class="form-check-label">{{$enum}}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <?php else:?>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{$key}}</label>
                                            <input type="text" name="option[{{$index}}][{{$key}}]" placeholder="{{@$val->placeholder}}" value="{{$value}}"
                                                   class="form-control">
                                        </div>
                                        <?php endif;?>
                                        <?php else:?>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{$key}}</label>
                                            <input type="text" name="option[{{$index}}][{{$key}}]" placeholder="{{$val}}" value="{{$value}}" class="form-control">
                                        </div>

                                        <?php endif;?>
                                        <?php endforeach; endif;?>

                                        <?php
                                        if(@$types->attribute->requiredOne):
                                        foreach($types->attribute->requiredOne as $key=>$val):
                                        @$value = $form[$key];
                                        ?>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{$key}}</label>
                                            <input type="text" name="option[{{$index}}][{{$key}}]" placeholder="{{$val}}" value="{{$value}}" class="form-control">
                                        </div>
                                        <?php endforeach; endif;?>

                                        <?php
                                        if(@$types->attribute->optional):
                                        foreach($types->attribute->optional as $key=>$val):
                                        @$value = $form[$key];
                                        ?>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{$key}}</label>
                                            @if(is_object($val) && property_exists($val, 'type') && $val->type == 'textarea')
                                                <textarea type="text" name="option[{{$index}}][{{$key}}]" placeholder="{{$val->placeholder}}"
                                                          class="form-control">{{$value}}</textarea>
                                            @else
                                                <input type="text" name="option[{{$index}}][{{$key}}]" placeholder="{{$val}}" value="{{$value}}"
                                                       class="form-control">
                                            @endif
                                        </div>
                                        <?php endforeach; endif;?>

                                        <?php endif;?>
                                    </div>
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
                            <?php $index++;?>
                        @endforeach

                        <tr id='tr-sample' style="display: none">
                            <td><input type='text' placeholder="Input field label" onclick='showColumnSuggest(this)' onkeyup="showColumnSuggestLike(this)"
                                       class='form-control labels' name='label[]'/></td>
                            <td><input type='text' placeholder="Input field name" onclick='showNameSuggest(this)' onkeyup="showNameSuggestLike(this)"
                                       class='form-control name' name='name[]'/></td>
                            <td><input type='text' placeholder="Input field type" onclick='showTypeSuggest(this)' onkeyup="showTypeSuggestLike(this)"
                                       class='form-control type' name='type[]'/></td>
                            <td><input type='text' class='form-control validation' onclick="showValidationSuggest(this)" onkeyup="showValidationSuggestLike(this)"
                                       name='validation[]' value='required' placeholder='Enter Laravel Validation'/></td>
                            <td>
                                <select class='form-select width' name='width[]'>
                                    @for($i=10;$i>=1;$i--)
                                        <option {{ ($i==9)?"selected":"" }} value='col-sm-{{$i}}'>{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>
                                <a class='btn btn-sm btn-outline-primary btn-options' href='javascript:;'><i class='bi bi-gear'></i> Options</a>
                                <div class='option_area' style="display: none"></div>
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
                <button type="button" onclick="location.href='{{CRUDBooster::mainpath('step2').'/'.$id}}'" class="btn btn-outline-secondary">&laquo; Back</button>
                <input type="submit" class="btn btn-primary" value="Step 4 &raquo;">
            </div>
        </form>
    </div>

@endsection
