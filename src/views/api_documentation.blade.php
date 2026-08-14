@extends('crudbooster::admin_template')

@section('content')

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link active" href="{{ CRUDBooster::mainpath() }}"><i class='bi bi-file-earmark-text me-1'></i> API Documentation</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ CRUDBooster::mainpath('screet-key') }}"><i class='bi bi-key me-1'></i> API Secret Key</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ CRUDBooster::mainpath('generator') }}"><i class='bi bi-gear me-1'></i> API Generator</a></li>
    </ul>

    <div class='card mb-4'>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">API Documentation</h5>
            <div class="d-flex gap-2">
                <a class="btn btn-sm btn-primary" target="_blank" href="{{ url('api-documentation') }}"><i class="bi bi-globe me-1"></i> Public Documentation</a>
                <a class='btn btn-sm btn-warning text-dark' target="_blank" href='{{CRUDBooster::mainpath("download-postman")}}'><i class="bi bi-download me-1"></i> Export For POSTMAN <sup>Beta</sup></a>
            </div>
        </div>

        <div class='card-body'>

            @push('head')
                <style>
                    .table-api tbody tr td a {
                        color: #0d6efd;
                        font-weight: 500;
                    }
                </style>
            @endpush

            @push('bottom')
                <script>
                    $(function () {
                        $(".link_name_api").click(function () {
                            $(".detail_api").slideUp();
                            $(this).parent("td").find(".detail_api").slideDown();
                        })
                        $(".selected_text").each(function () {
                            var n = $(this).text();
                            if (n.indexOf('api_') == 0) {
                                $(this).attr('class', 'selected_text text-danger');
                            }
                        })
                    })

                    function deleteApi(id) {
                        var url = "{{url(config('crudbooster.ADMIN_PATH').'/api_generator/delete-api')}}/" + id;
                        swal({
                            title: "Are you sure?",
                            text: "You will not be able to recover this data!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            closeOnConfirm: false
                        }, function () {
                            $.get(url, function (resp) {
                                if (resp.status == 1) {
                                    swal("Deleted!", "The data has been deleted.", "success");
                                    location.href = document.location.href;
                                }
                            })
                        });
                    }
                </script>
            @endpush

            <div class='mb-3'>
                <label class="form-label fw-bold">API BASE URL</label>
                <input type='text' readonly class='form-control' title='Click to copy to clipboard'
                       onClick="this.setSelectionRange(0, this.value.length); document.execCommand('copy');" value='{{url('api')}}'/>
            </div>

            <div class="table-responsive">
                <table class='table table-striped table-api table-bordered align-middle'>
                    <thead>
                    <tr>
                        <th width='3%'>No</th>
                        <th>API Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 0;?>

                    <tr>
                        <td>{{ ++$no  }}</td>
                        <td>
                            <a href='javascript:void(0)' title='API Authentication' class='link_name_api text-danger fw-bold'>Authentication (Request Token)</a> &nbsp;
                            <div class='detail_api mt-2' style='display:none'>
                                <table class='table table-bordered align-middle'>
                                    <tr>
                                        <td width='12%'><strong>URL</strong></td>
                                        <td><input title='Click to copy!' type='text' class='form-control form-control-sm' readonly
                                                   onClick="this.setSelectionRange(0, this.value.length); document.execCommand('copy');"
                                                   value="/get-token"/></td>
                                    </tr>
                                    <tr>
                                        <td><strong>METHOD</strong></td>
                                        <td><span class="badge bg-success">POST</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PARAMETER</strong></td>
                                        <td>
                                            <table class='table table-bordered table-hover align-middle mb-0'>
                                                <thead>
                                                <tr>
                                                    <th width="3%">No</th>
                                                    <th width="10%">Type</th>
                                                    <th>Parameter Names</th>
                                                    <th>Description / Validate / Rule</th>
                                                    <th>Mandatory</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><em>String</em></td>
                                                        <td>secret</td>
                                                        <td></td>
                                                        <td><span class="badge bg-danger">Yes</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>RESPONSE</strong></td>
                                        <td>
                                            <table class='table table-bordered table-hover align-middle mb-0'>
                                                <thead>
                                                <tr>
                                                    <th width="3%">No</th>
                                                    <th width="10%">Type</th>
                                                    <th>Response Names</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><em>integer</em></td>
                                                        <td>api_status</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td><em>string</em></td>
                                                        <td>api_message</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td><em>object</em></td>
                                                        <td>data</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.1</td>
                                                        <td><em>string</em></td>
                                                        <td>access_token</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.2</td>
                                                        <td><em>integer</em></td>
                                                        <td>expiry</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    @foreach($apis as $api)
                        <?php
                        $parameters = ($api->parameters) ? unserialize($api->parameters) : array();
                        $responses = ($api->responses) ? unserialize($api->responses) : array();
                        ?>
                        <tr>
                            <td><?= ++$no;?></td>
                            <td>
                                <a href='javascript:void(0)' title='API {{@$api->nama}}' class='link_name_api'><?=$api->nama;?></a> &nbsp;
                                <span class="ms-2">
                                    <a title='Edit This API' class="text-primary me-2" href="{{url(config('crudbooster.ADMIN_PATH').'/api_generator/edit-api').'/'.$api->id}}"><i class='bi bi-pencil'></i></a>
                                    <a title='Delete this API' class="text-danger" onclick="deleteApi({{$api->id}})" href="javascript:void(0)"><i class='bi bi-trash'></i></a>
                                </span>
                                <div class='detail_api mt-2' style='display:none'>
                                    <table class='table table-bordered align-middle'>
                                        <tr>
                                            <td width='12%'><strong>URL</strong></td>
                                            <td><input title='Click to copy!' type='text' class='form-control form-control-sm' readonly
                                                       onClick="this.setSelectionRange(0, this.value.length); document.execCommand('copy');"
                                                       value="/{{$api->permalink}}"/></td>
                                        </tr>
                                        <tr>
                                            <td><strong>METHOD</strong></td>
                                            <td><span class="badge {{ strtoupper($api->method_type) == 'POST' ? 'bg-success' : 'bg-primary' }}">{{strtoupper($api->method_type)}}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>HEADERS</strong></td>
                                            <td>
                                                <table class="table table-bordered table-hover align-middle mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Authorization</td>
                                                            <td>Bearer <span class="text-danger">{access_token}</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>PARAMETER</strong></td>
                                            <td>
                                                <table class='table table-bordered table-hover align-middle mb-0'>
                                                    <thead>
                                                    <tr>
                                                        <th width="3%">No</th>
                                                        <th width="10%">Type</th>
                                                        <th>Parameter Names</th>
                                                        <th>Description / Validate / Rule</th>
                                                        <th>Mandatory</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0;?>
                                                    @foreach($parameters as $param)
                                                        @if($param['used'])
                                                            <?php
                                                            $param_exception = ['in', 'not_in', 'digits_between'];
                                                            if ($param['config'] && substr($param['config'], 0, 1) != '*' && ! in_array($param['type'], $param_exception)) continue;?>
                                                            <tr>
                                                                <td>{{++$i}}</td>
                                                                <td width="10%"><em>{{$param['type']}}</em></td>
                                                                <td>{{$param['name']}}</td>
                                                                <td>
                                                                    @if(substr($param['config'],0,1) == '*')
                                                                        <span class='text-info'>{{substr($param['config'],1)}}</span>
                                                                    @else
                                                                        {{$param['config']}}
                                                                    @endif
                                                                </td>
                                                                <td>{!! ($param['required'])?"<span class='badge bg-danger'>REQUIRED</span>":"<span class='badge bg-secondary'>OPTIONAL</span>"!!}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @if($i == 0)
                                                        <tr>
                                                            <td colspan='5' class="text-center text-muted"><i class='bi bi-search me-1'></i> There is no parameter</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>RESPONSE</strong></td>
                                            <td>
                                                <table class='table table-bordered table-hover align-middle mb-0'>
                                                    <thead>
                                                    <tr>
                                                        <th width="3%">No</th>
                                                        <th width="10%">Type</th>
                                                        <th>Response Names</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0;?>
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td><em>integer</em></td>
                                                        <td>api_status</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ ++$i}}</td>
                                                        <td><em>string</em></td>
                                                        <td>api_message</td>
                                                    </tr>

                                                    @if($api->aksi == 'list')
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>Array</td>
                                                            <td><strong>data</strong></td>
                                                        </tr>
                                                    @endif

                                                    @if($api->aksi == 'detail')
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>Object</td>
                                                            <td><strong>data</strong></td>
                                                        </tr>
                                                    @endif

                                                    @php $ii = 0; @endphp

                                                    @if($api->aksi == 'list' || $api->aksi == 'detail')
                                                        @foreach($responses as $resp)
                                                            @if($resp['used'])
                                                                <tr>
                                                                    <td>{{$i.".".(++$ii)}}</td>
                                                                    <td width="10%"><em>{{$resp['type']}}</em></td>
                                                                    <td>{{ ($api->aksi=='list')?'- ':'' }} {{$resp['name']}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($api->aksi == 'save_add')
                                                        <tr>
                                                            <td width="10%">{{ ++$i }}</td>
                                                            <td><em>integer</em></td>
                                                            <td>id</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>DESCRIPTION</strong></td>
                                            <td><em>{!! $api->keterangan !!}</em></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div><!--END BODY-->
    </div><!--END CARD-->

@endsection