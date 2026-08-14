@extends('crudbooster::admin_template')
@section('content')

    <div>

        @if(CRUDBooster::getCurrentMethod() != 'getProfile' && @$button_cancel)
            @if(g('return_url'))
                <p><a title='Return' href='{{g("return_url")}}' class="btn btn-outline-secondary btn-sm"><i class='bi bi-chevron-left'></i>
                        &nbsp; {{cbLang("form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
            @else
                <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}' class="btn btn-outline-secondary btn-sm"><i class='bi bi-chevron-left'></i>
                        &nbsp; {{cbLang("form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
            @endif
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {!! @$page_title !!}</h5>
            </div>

            <div class="card-body">
                <?php
                $action = (@$row) ? CRUDBooster::mainpath("edit-save/$row->id") : CRUDBooster::mainpath("add-save");
                $return_url = (@$return_url) ?: g('return_url');
                ?>
                <form method='post' id="form" enctype="multipart/form-data" action='{{$action}}'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type='hidden' name='return_url' value='{{ @$return_url }}'/>
                    <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}'/>
                    <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}'/>
                    @if(@$hide_form)
                        <input type="hidden" name="hide_form" value='{!! serialize($hide_form) !!}'>
                    @endif
                    <div id="parent-form-area">

                        @if(@$command == 'detail')
                            @include("crudbooster::default.form_detail")
                        @else
                            @include("crudbooster::default.form_body")
                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                @if(@$button_cancel && CRUDBooster::getCurrentMethod() != 'getDetail')
                                    @if(g('return_url'))
                                        <a href='{{g("return_url")}}' class='btn btn-outline-secondary'><i
                                                    class='bi bi-chevron-left'></i> {{cbLang("button_back")}}</a>
                                    @else
                                        <a href='{{CRUDBooster::mainpath("?".http_build_query(@$_GET)) }}' class='btn btn-outline-secondary'><i
                                                    class='bi bi-chevron-left'></i> {{cbLang("button_back")}}</a>
                                    @endif
                                @endif
                                @if(CRUDBooster::isCreate() || CRUDBooster::isUpdate())

                                    @if(CRUDBooster::isCreate() && @$button_addmore==TRUE && @$command == 'add')
                                        <input type="submit" name="submit" value='{{cbLang("button_save_more")}}' class='btn btn-success'>
                                    @endif

                                    @if(@$button_save && @$command != 'detail')
                                        <input type="submit" name="submit" value='{{cbLang("button_save")}}' class='btn btn-success'>
                                    @endif

                                @endif
                            </div>
                        </div>
                    </div><!-- /.card-footer-->

                </form>

            </div>
        </div>
    </div><!--END AUTO MARGIN-->

@endsection
