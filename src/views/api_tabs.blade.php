@extends('crudbooster::admin_template')

@section('content')

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link {{ Request::is('*documentation*') ? 'active' : '' }}" href="{{ CRUDBooster::mainpath('documentation') }}"><i class='bi bi-file-earmark-text me-1'></i> API Documentation</a></li>
        <li class="nav-item"><a class="nav-link {{ Request::is('*screet-key*') ? 'active' : '' }}" href="{{ CRUDBooster::mainpath('screet-key') }}"><i class='bi bi-key me-1'></i> API Secret Key</a></li>
        <li class="nav-item"><a class="nav-link {{ Request::is('*generator*') ? 'active' : '' }}" href="{{ CRUDBooster::mainpath('generator') }}"><i class='bi bi-gear me-1'></i> API Generator</a></li>
    </ul>

    <div class='card mb-4'>
        <div class='card-header'><h5 class='card-title mb-0'>API Documentation</h5></div>
        <div class='card-body'>
            @include('crudbooster::api_documentation')
        </div>
    </div>

@endsection