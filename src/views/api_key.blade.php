@extends('crudbooster::admin_template')

@section('content')

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link" href="{{ CRUDBooster::mainpath() }}"><i class='bi bi-file-earmark-text me-1'></i> API Documentation</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ CRUDBooster::mainpath('screet-key') }}"><i class='bi bi-key me-1'></i> API Secret Key</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ CRUDBooster::mainpath('generator') }}"><i class='bi bi-gear me-1'></i> API Generator</a></li>
    </ul>

    <div class='card mb-4'>
        <div class='card-header d-flex justify-content-between align-items-center'>
            <h5 class='card-title mb-0'>API Secret Key</h5>
            <a title='Generate API Key' class='btn btn-primary btn-sm' href='javascript:void(0)' onclick='generate_screet_key()'><i class='bi bi-key me-1'></i> Generate Secret Key</a>
        </div>
        <div class='card-body'>
            <div class="table-responsive">
                <table id='table-apikey' class='table table-striped table-bordered align-middle'>
                    <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th>Secret Key</th>
                        <th width="10%">Hit</th>
                        <th width="10%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 0;?>
                    @foreach($apikeys as $row)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td><code>{{ $row->screetkey }}</code></td>
                            <td>{{ $row->hit }}</td>
                            <td>{!! ($row->status=='active')?"<span class='badge bg-success'>Active</span>":"<span class='badge bg-secondary'>Non Active</span>" !!}</td>
                            <td>
                                @if($row->status == 'active')
                                    <a class='btn btn-sm btn-outline-secondary' href='{{ CRUDBooster::mainpath("status-apikey?id=$row->id&status=0") }}'>Non Active</a>
                                @else
                                    <a class='btn btn-sm btn-outline-success' href='{{ CRUDBooster::mainpath("status-apikey?id=$row->id&status=1") }}'>Active</a>
                                @endif

                                <a class='btn btn-sm btn-danger' href='javascript:void(0)' onclick='deleteApi({{$row->id}})'>Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($apikeys)==0)
                        <tr class='no-screetkey'>
                            <td colspan='5' class="text-center text-muted">There is no secret key found, <a href='javascript:void(0)' onclick='generate_screet_key()'>Click here to generate one</a></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            @push('bottom')
                <script>
                    var lastno = <?=$no?>;

                    function generate_screet_key() {
                        $.get("<?php echo route('ApiCustomControllerGetGenerateScreetKey')?>", function (resp) {
                            lastno += 1;
                            $('#table-apikey').append("<tr><td>" + lastno + "</td><td><code>" + resp.key + "</code></td><td>0</td><td><span class='badge bg-success'>Active</span></td><td>" +
                                "<a class='btn btn-sm btn-outline-secondary me-1' href='{{CRUDBooster::mainpath("status-apikey")}}?id=" + resp.id + "&status=0'>Non Active</a><a class='btn btn-sm btn-danger' href='javascript:void(0)' onclick='deleteApi(" + resp.id + ")'>Delete</a> </td></tr>"
                            );
                            $('.no-screetkey').remove();
                            swal("Success!", "Your new secret key has been generated successfully", "success");
                        })
                    }

                    function deleteApi(id) {
                        swal({
                            title: "Are you sure ?",
                            text: "You will not be able to recover this data!",
                            type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!", closeOnConfirm: false
                        }, function () {
                            $.get("{{CRUDBooster::mainpath('delete-api-key')}}?id=" + id, function (resp) {
                                if (resp.status == 1) {
                                    swal("Success!", "The secret key has been deleted !", "success");
                                } else {
                                    swal("Upps!", "The secret key can't delete !", "warning");
                                }
                                location.href = document.location.href;
                            })
                        })
                    }
                </script>
            @endpush

        </div><!--END BODY-->
    </div><!--END CARD-->

@endsection