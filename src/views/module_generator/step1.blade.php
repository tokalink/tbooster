@extends("crudbooster::admin_template")
@section("content")

    @push('head')
        <link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css")?>'/>
        <link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/adminlte4/css/adminlte-select2.min.css")?>'/>
    @endpush

    @push('bottom')
        <script src='<?php echo asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js")?>'></script>
        <script>
            $(function () {
                $('.select2').select2({ width: '100%' });
                $('select[name=table]').change(function () {
                    var v = $(this).val().replace(".", "_");
                    $.get("{{CRUDBooster::mainpath('check-slug')}}/" + v, function (resp) {
                        if (resp.total == 0) {
                            $('input[name=path]').val(v);
                        } else {
                            v = v + resp.lastid;
                            $('input[name=path]').val(v);
                        }
                    })
                })
            })
        </script>
    @endpush

    <ul class="nav nav-tabs mb-3">
        @if($id)
            <li class="nav-item"><a class="nav-link active" href="{{Route('ModulsControllerGetStep1')."/".$id}}"><i class='bi bi-info-circle me-1'></i> Step 1 - Module Information</a></li>
            <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep2')."/".$id}}"><i class='bi bi-table me-1'></i> Step 2 - Table Display</a></li>
            <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep3')."/".$id}}"><i class='bi bi-plus-square me-1'></i> Step 3 - Form Display</a></li>
            <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep4')."/".$id}}"><i class='bi bi-gear me-1'></i> Step 4 - Configuration</a></li>
        @else
            <li class="nav-item"><a class="nav-link active" href="#"><i class='bi bi-info-circle me-1'></i> Step 1 - Module Information</a></li>
            <li class="nav-item"><a class="nav-link disabled" href="#"><i class='bi bi-table me-1'></i> Step 2 - Table Display</a></li>
            <li class="nav-item"><a class="nav-link disabled" href="#"><i class='bi bi-plus-square me-1'></i> Step 3 - Form Display</a></li>
            <li class="nav-item"><a class="nav-link disabled" href="#"><i class='bi bi-gear me-1'></i> Step 4 - Configuration</a></li>
        @endif
    </ul>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Module Information</h5>
        </div>
        <form method="post" action="{{Route('ModulsControllerPostStep2')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" value="{{@$row->id}}">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Table</label>
                    <select name="table" id="table" required class="select2 form-select" value="{{@$row->table_name}}">
                        <option value="">{{cbLang('text_prefix_option')}} Table</option>
                        @foreach($tables_list as $table)
                            <option {{($table == @$row->table_name)?"selected":""}} value="{{$table}}">{{$table}}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-muted">Do not use cms_* as prefix on your tables name</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Module Name</label>
                    <input type="text" class="form-control" required name="name" value="{{@$row->name}}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Icon</label>
                    <select name="icon" id="icon" required class="select2 form-select">
                        @foreach($fontawesome as $f)
                            <option {{(@$row->icon == 'fa fa-'.$f)?"selected":""}} value="fa fa-{{$f}}">{{$f}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Module Slug</label>
                    <input type="text" class="form-control" required name="path" value="{{@$row->path}}">
                    <div class="form-text text-muted">Please alpha numeric only, without space instead _ and or special character</div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" checked type='checkbox' name='create_menu' id="create_menu" value='1'/>
                    <label class="form-check-label" for="create_menu">
                        Also create menu for this module
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <a class='btn btn-outline-secondary' href='{{Route("ModulsControllerGetIndex")}}'> {{cbLang('button_back')}}</a>
                    <input type="submit" class="btn btn-primary" value="Step 2 &raquo;">
                </div>
            </div>
        </form>
    </div>

@endsection
