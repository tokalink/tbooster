@extends('crudbooster::admin_template')

@section('content')

    <div style="max-width: 900px; margin: 0 auto;">

        @if(CRUDBooster::getCurrentMethod() != 'getProfile')
            <p><a class="btn btn-outline-secondary btn-sm mb-3" href='{{CRUDBooster::mainpath()}}'><i class="bi bi-arrow-left me-1"></i> {{cbLang("form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $page_title }}</h5>
            </div>
            <form method='post' action='{{ (@$row->id)?route("PrivilegesControllerPostEditSave")."/$row->id":route("PrivilegesControllerPostAddSave") }}'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> To show the menu you have to create a menu at Menu Management
                    </div>
                    <div class='mb-3'>
                        <label class="form-label fw-bold">{{cbLang('privileges_name')}}</label>
                        <input type='text' class='form-control' name='name' required value='{{ @$row->name }}'/>
                        <div class="text-danger small">{{ $errors->first('name') }}</div>
                    </div>

                    <div class='mb-3'>
                        <label class="form-label fw-bold d-block">{{cbLang('set_as_superadmin')}}</label>
                        <div id='set_as_superadmin'>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" required {{ (@$row->is_superadmin==1)?'checked':'' }} type='radio' name='is_superadmin' id="sa_yes" value='1'/>
                                <label class="form-check-label" for="sa_yes">{{cbLang('confirmation_yes')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ (@$row->is_superadmin==0)?'checked':'' }} type='radio' name='is_superadmin' id="sa_no" value='0'/>
                                <label class="form-check-label" for="sa_no">{{cbLang('confirmation_no')}}</label>
                            </div>
                        </div>
                        <div class="text-danger small">{{ $errors->first('is_superadmin') }}</div>
                    </div>

                    <div class='mb-3'>
                        <label class="form-label fw-bold">{{cbLang('chose_theme_color')}}</label>
                        <select name='theme_color' class='form-select' required>
                            <option value=''>{{cbLang('chose_theme_color_select')}}</option>
                            <?php
                            $skins = array(
                                'skin-blue',
                                'skin-blue-light',
                                'skin-yellow',
                                'skin-yellow-light',
                                'skin-green',
                                'skin-green-light',
                                'skin-purple',
                                'skin-purple-light',
                                'skin-red',
                                'skin-red-light',
                                'skin-black',
                                'skin-black-light'
                            );
                            foreach($skins as $skin):
                            ?>
                            <option <?=(@$row->theme_color == $skin) ? "selected" : ""?> value='<?=$skin?>'><?=ucwords(str_replace('-', ' ', $skin))?></option>
                            <?php endforeach;?>
                        </select>
                        <div class="text-danger small">{{ $errors->first('theme_color') }}</div>
                        @push('bottom')
                            <script type="text/javascript">
                                $(function () {
                                    $("select[name=theme_color]").change(function () {
                                        var n = $(this).val();
                                        $("body").attr("class", "layout-fixed sidebar-expand-lg bg-body-tertiary " + n);
                                    })

                                    $('#set_as_superadmin input').click(function () {
                                        var n = $(this).val();
                                        if (n == '1') {
                                            $('#privileges_configuration').hide();
                                        } else {
                                            $('#privileges_configuration').show();
                                        }
                                    })

                                    $('#set_as_superadmin input:checked').trigger('click');
                                })
                            </script>
                        @endpush
                    </div>

                    <div id='privileges_configuration' class='mb-3'>
                        <label class="form-label fw-bold mb-2">{{cbLang('privileges_configuration')}}</label>
                        @push('bottom')
                            <script>
                                $(function () {
                                    $("#is_visible").click(function () {
                                        var is_ch = $(this).prop('checked');
                                        $(".is_visible").prop("checked", is_ch);
                                    })
                                    $("#is_create").click(function () {
                                        var is_ch = $(this).prop('checked');
                                        $(".is_create").prop("checked", is_ch);
                                    })
                                    $("#is_read").click(function () {
                                        var is_ch = $(this).is(':checked');
                                        $(".is_read").prop("checked", is_ch);
                                    })
                                    $("#is_edit").click(function () {
                                        var is_ch = $(this).is(':checked');
                                        $(".is_edit").prop("checked", is_ch);
                                    })
                                    $("#is_delete").click(function () {
                                        var is_ch = $(this).is(':checked');
                                        $(".is_delete").prop("checked", is_ch);
                                    })
                                    $(".select_horizontal").click(function () {
                                        var p = $(this).parents('tr');
                                        var is_ch = $(this).is(':checked');
                                        p.find("input[type=checkbox]").prop("checked", is_ch);
                                    })
                                })
                            </script>
                        @endpush
                        <div class="table-responsive">
                            <table class='table table-striped table-hover table-bordered align-middle'>
                                <thead>
                                <tr>
                                    <th width='3%'>{{cbLang('privileges_module_list_no')}}</th>
                                    <th width='40%'>{{cbLang('privileges_module_list_mod_names')}}</th>
                                    <th width="5%">&nbsp;</th>
                                    <th class="text-center">{{cbLang('privileges_module_list_view')}}</th>
                                    <th class="text-center">{{cbLang('privileges_module_list_create')}}</th>
                                    <th class="text-center">{{cbLang('privileges_module_list_read')}}</th>
                                    <th class="text-center">{{cbLang('privileges_module_list_update')}}</th>
                                    <th class="text-center">{{cbLang('privileges_module_list_delete')}}</th>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <td align="center"><input title='Check all vertical' class="form-check-input" type='checkbox' id='is_visible'/></td>
                                    <td align="center"><input title='Check all vertical' class="form-check-input" type='checkbox' id='is_create'/></td>
                                    <td align="center"><input title='Check all vertical' class="form-check-input" type='checkbox' id='is_read'/></td>
                                    <td align="center"><input title='Check all vertical' class="form-check-input" type='checkbox' id='is_edit'/></td>
                                    <td align="center"><input title='Check all vertical' class="form-check-input" type='checkbox' id='is_delete'/></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1;?>
                                @foreach($moduls as $modul)
                                    <?php
                                    $roles = DB::table('cms_privileges_roles')->where('id_cms_moduls', $modul->id)->where('id_cms_privileges', @$row->id ?: 0)->first();
                                    ?>
                                    <tr>
                                        <td><?php echo $no++;?></td>
                                        <td>{{$modul->name}}</td>
                                        <td align="center"><input type='checkbox' class="form-check-input select_horizontal" title='Check All Horizontal'
                                                                               <?=(@$roles->is_create && @$roles->is_read && @$roles->is_edit && @$roles->is_delete) ? "checked" : ""?>/>
                                        </td>
                                        <td align="center"><input type='checkbox' class='form-check-input is_visible' name='privileges[<?=$modul->id?>][is_visible]'
                                                                                 <?=@$roles->is_visible ? "checked" : ""?> value='1'/></td>
                                        <td align="center"><input type='checkbox' class='form-check-input is_create' name='privileges[<?=$modul->id?>][is_create]'
                                                                                  <?=@$roles->is_create ? "checked" : ""?> value='1'/></td>
                                        <td align="center"><input type='checkbox' class='form-check-input is_read' name='privileges[<?=$modul->id?>][is_read]'
                                                                               <?=@$roles->is_read ? "checked" : ""?> value='1'/></td>
                                        <td align="center"><input type='checkbox' class='form-check-input is_edit' name='privileges[<?=$modul->id?>][is_edit]'
                                                                                  <?=@$roles->is_edit ? "checked" : ""?> value='1'/></td>
                                        <td align="center"><input type='checkbox' class='form-check-input is_delete' name='privileges[<?=$modul->id?>][is_delete]'
                                                                                 <?=@$roles->is_delete ? "checked" : ""?> value='1'/></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type='button' onclick="location.href='{{CRUDBooster::mainpath()}}'"
                            class='btn btn-outline-secondary'>{{cbLang("button_cancel")}}</button>
                    <button type='submit' class='btn btn-primary'><i class='bi bi-save me-1'></i> {{cbLang("button_save")}}</button>
                </div>
            </form>
        </div>

    </div>
@endsection
