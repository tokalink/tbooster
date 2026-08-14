@extends("crudbooster::admin_template")
@section("content")

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep1')."/".$id}}"><i class='bi bi-info-circle me-1'></i> Step 1 - Module Information</a></li>
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep2')."/".$id}}"><i class='bi bi-table me-1'></i> Step 2 - Table Display</a></li>
        <li class="nav-item"><a class="nav-link" href="{{Route('ModulsControllerGetStep3')."/".$id}}"><i class='bi bi-plus-square me-1'></i> Step 3 - Form Display</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{Route('ModulsControllerGetStep4')."/".$id}}"><i class='bi bi-gear me-1'></i> Step 4 - Configuration</a></li>
    </ul>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Configuration</h5>
        </div>
        <form method='post' action='{{Route('ModulsControllerPostStepFinish')}}'>
            {{csrf_field()}}
            <input type="hidden" name="id" value='{{$id}}'>
            <div class="card-body">

                <div class="row g-3">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title Field Candidate</label>
                            <input type="text" name="title_field" value="{{$cb_title_field}}" class='form-control'>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Limit Data</label>
                            <input type="number" name="limit" value="{{$cb_limit}}" class='form-control'>
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Order By</label>
                            <?php
                            if (is_array($cb_orderby)) {
                                $orderby = [];
                                foreach ($cb_orderby as $k => $v) {
                                    $orderby[] = $k.','.$v;
                                }
                                $orderby = implode(";", $orderby);
                            } else {
                                $orderby = $cb_orderby;
                            }
                            ?>
                            <input type="text" name="orderby" value="{{$orderby}}" class='form-control'>
                            <div class="form-text text-muted">E.g : column_name,desc</div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Global Privilege</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type='radio' name='global_privilege' id="gp_true" {{($cb_global_privilege)?"checked":""}} value='true'/>
                                <label class="form-check-label" for="gp_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_global_privilege)?"checked":""}} type='radio' name='global_privilege' id="gp_false" value='false'/>
                                <label class="form-check-label" for="gp_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Table Action</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_table_action)?"checked":""}} type='radio' name='button_table_action' id="bta_true" value='true'/>
                                <label class="form-check-label" for="bta_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_table_action)?"checked":""}} type='radio' name='button_table_action' id="bta_false" value='false'/>
                                <label class="form-check-label" for="bta_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Bulk Action Button</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_bulk_action)?"checked":""}} type='radio' name='button_bulk_action' id="bba_true" value='true'/>
                                <label class="form-check-label" for="bba_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_bulk_action)?"checked":""}} type='radio' name='button_bulk_action' id="bba_false" value='false'/>
                                <label class="form-check-label" for="bba_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Button Action Style</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_action_style=='button_icon')?"checked":""}} type='radio' name='button_action_style' id="bas_icon" value='button_icon'/>
                                <label class="form-check-label" for="bas_icon">Icon</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_action_style=='button_icon_text')?"checked":""}} type='radio' name='button_action_style' id="bas_icon_text" value='button_icon_text'/>
                                <label class="form-check-label" for="bas_icon_text">Icon & Text</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_action_style=='button_text')?"checked":""}} type='radio' name='button_action_style' id="bas_text" value='button_text'/>
                                <label class="form-check-label" for="bas_text">Button Text</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_action_style=='button_dropdown')?"checked":""}} type='radio' name='button_action_style' id="bas_dropdown" value='button_dropdown'/>
                                <label class="form-check-label" for="bas_dropdown">Dropdown</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Add</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_add)?"checked":""}} type='radio' name='button_add' id="ba_true" value='true'/>
                                <label class="form-check-label" for="ba_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_add)?"checked":""}} type='radio' name='button_add' id="ba_false" value='false'/>
                                <label class="form-check-label" for="ba_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Edit</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_edit)?"checked":""}} type='radio' name='button_edit' id="be_true" value='true'/>
                                <label class="form-check-label" for="be_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_edit)?"checked":""}} type='radio' name='button_edit' id="be_false" value='false'/>
                                <label class="form-check-label" for="be_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Delete</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_delete)?"checked":""}} type='radio' name='button_delete' id="bd_true" value='true'/>
                                <label class="form-check-label" for="bd_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_delete)?"checked":""}} type='radio' name='button_delete' id="bd_false" value='false'/>
                                <label class="form-check-label" for="bd_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Detail</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_detail)?"checked":""}} type='radio' name='button_detail' id="bdt_true" value='true'/>
                                <label class="form-check-label" for="bdt_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_detail)?"checked":""}} type='radio' name='button_detail' id="bdt_false" value='false'/>
                                <label class="form-check-label" for="bdt_false">FALSE</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Show Data</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_show)?"checked":""}} type='radio' name='button_show' id="bs_true" value='true'/>
                                <label class="form-check-label" for="bs_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_show)?"checked":""}} type='radio' name='button_show' id="bs_false" value='false'/>
                                <label class="form-check-label" for="bs_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Filter & Sorting</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_filter)?"checked":""}} type='radio' name='button_filter' id="bf_true" value='true'/>
                                <label class="form-check-label" for="bf_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_filter)?"checked":""}} type='radio' name='button_filter' id="bf_false" value='false'/>
                                <label class="form-check-label" for="bf_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Import</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_import)?"checked":""}} type='radio' name='button_import' id="bi_true" value='true'/>
                                <label class="form-check-label" for="bi_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_import)?"checked":""}} type='radio' name='button_import' id="bi_false" value='false'/>
                                <label class="form-check-label" for="bi_false">FALSE</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Show Button Export</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{($cb_button_export)?"checked":""}} type='radio' name='button_export' id="bx_true" value='true'/>
                                <label class="form-check-label" for="bx_true">TRUE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" {{(!$cb_button_export)?"checked":""}} type='radio' name='button_export' id="bx_false" value='false'/>
                                <label class="form-check-label" for="bx_false">FALSE</label>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="button" onclick="location.href='{{CRUDBooster::mainpath('step3').'/'.$id}}'" class="btn btn-outline-secondary">&laquo; Back</button>
                <input type="submit" name="submit" class='btn btn-success' value='Save Module'>
            </div>
        </form>
    </div>

@endsection