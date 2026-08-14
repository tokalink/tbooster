@extends('crudbooster::admin_template')

@section('content')

    @if($index_statistic)
        <div id='box-statistic' class='row g-3 mb-3'>
            @foreach($index_statistic as $stat)
                <div class="{{ ($stat['width'])?:'col-sm-3' }}">
                    <div class="small-box text-bg-{{ $stat['color']?:'danger' }}">
                        <div class="inner">
                            <h3>{{ $stat['count'] }}</h3>
                            <p>{{ $stat['label'] }}</p>
                        </div>
                        <div class="icon">
                            <i class="{{ $stat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($pre_index_html) && !empty($pre_index_html))
        {!! $pre_index_html !!}
    @endif

    @if(g('return_url'))
        <p><a href='{{g("return_url")}}' class="btn btn-outline-secondary btn-sm"><i class='bi bi-chevron-left'></i>
                &nbsp; {{cbLang('form_back_to_list',['module'=>urldecode(g('label'))])}}</a></p>
    @endif

    @if(isset($parent_table) && $parent_table)
        <div class="card mb-3">
            <div class="card-body p-0 table-responsive">
                <table class='table table-bordered m-0'>
                    <tbody>
                    <tr class='table-secondary'>
                        <td colspan="2"><strong><i class='bi bi-list'></i> {{ ucwords(urldecode(g('label'))) }}</strong></td>
                    </tr>
                    @foreach(explode(',',urldecode(g('parent_columns'))) as $c)
                        <tr>
                            <td width="25%"><strong>
                                     @if(urldecode(g('parent_columns_alias')))
                                         {{explode(',',urldecode(g('parent_columns_alias')))[$loop->index]}}
                                     @else
                                         {{ ucwords(str_replace('_',' ',$c)) }}
                                     @endif
                                 </strong></td>
                            <td> {{ $parent_table->$c }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                @if(isset($button_bulk_action) && $button_bulk_action && ( (isset($button_delete) && $button_delete && CRUDBooster::isDelete()) || isset($button_selected) && $button_selected) )
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-check2-square'></i> {{cbLang("button_selected_action")}}
                        </button>
                        <ul class="dropdown-menu">
                            @if(isset($button_delete) && $button_delete && CRUDBooster::isDelete())
                                <li><a class="dropdown-item text-danger" href="javascript:void(0)" data-name='delete' title='{{cbLang('action_delete_selected')}}'>
                                    <i class="bi bi-trash"></i> {{cbLang('action_delete_selected')}}
                                </a></li>
                            @endif

                            @if(isset($button_selected) && $button_selected)
                                @foreach($button_selected as $button)
                                    <li><a class="dropdown-item" href="javascript:void(0)" data-name='{{$button["name"]}}' title='{{$button["label"]}}'>
                                        <i class="bi bi-{{$button['icon']}}"></i> {{$button['label']}}
                                    </a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(isset($button_filter) && $button_filter)
                    <a href="javascript:void(0)" id='btn_advanced_filter' data-url-parameter='{{@$build_query}}'
                       title='{{cbLang('filter_dialog_title')}}' class="btn btn-sm btn-outline-secondary {{(Request::get('filter_column'))?'active':''}}">
                        <i class="bi bi-funnel"></i> {{cbLang("button_filter")}}
                    </a>
                @endif

                <form method='get' class="d-inline-block" action='{{Request::url()}}'>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" placeholder="{{cbLang('filter_search')}}"/>
                        {!! CRUDBooster::getUrlParameters(['q']) !!}
                        @if(Request::get('q'))
                            <?php
                            $parameters = Request::all();
                            unset($parameters['q']);
                            $build_query = urldecode(http_build_query($parameters));
                            $build_query = ($build_query) ? "?".$build_query : "";
                            $build_query = (Request::all()) ? $build_query : "";
                            ?>
                            <button type='button' onclick='location.href="{{ CRUDBooster::mainpath().$build_query}}"'
                                    title="{{cbLang('button_reset')}}" class='btn btn-warning'><i class='bi bi-x-circle'></i></button>
                        @endif
                        <button type='submit' class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                <form method='get' id='form-limit-paging' class="d-inline-block" action='{{Request::url()}}'>
                    {!! CRUDBooster::getUrlParameters(['limit']) !!}
                    <div class="input-group input-group-sm">
                        <select onchange="$('#form-limit-paging').submit()" name='limit' class='form-select'>
                            <option {{(isset($limit) && $limit==5)?'selected':''}} value='5'>5</option>
                            <option {{(isset($limit) && $limit==10)?'selected':''}} value='10'>10</option>
                            <option {{(isset($limit) && $limit==20)?'selected':''}} value='20'>20</option>
                            <option {{(isset($limit) && $limit==25)?'selected':''}} value='25'>25</option>
                            <option {{(isset($limit) && $limit==50)?'selected':''}} value='50'>50</option>
                            <option {{(isset($limit) && $limit==100)?'selected':''}} value='100'>100</option>
                            <option {{(isset($limit) && $limit==200)?'selected':''}} value='200'>200</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
            @include("crudbooster::default.table")
        </div>
    </div>

    @if(isset($post_index_html) && !empty($post_index_html))
        {!! $post_index_html !!}
    @endif

@endsection
