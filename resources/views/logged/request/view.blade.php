@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>
            <span class="badge {{$request->status->class}}">{{$language::get('request')}}</span>

            </h2>
        </div>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ (!\Session::has('tab') || (\Session::has('tab') && \Session::get('tab') == 'data')) ? 'active' : '' }}" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="{{ (\Session::has('tab') && \Session::get('tab') == 'data') ? 'true' : 'false' }}">{{$language::get('request')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (\Session::has('tab') && \Session::get('tab') == 'progress') ? 'active' : '' }}" id="progress-tab" data-toggle="tab" href="#progress" role="tab" aria-controls="progress" aria-selected="{{ (\Session::has('tab') && \Session::get('tab') == 'progress') ? 'true' : 'false' }}">{{$language::get('progress')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (\Session::has('tab') && \Session::get('tab') == 'attachment') ? 'active' : '' }}" id="attachment-tab" data-toggle="tab" href="#attachment" role="tab" aria-controls="attachment" aria-selected="{{ (\Session::has('tab') && \Session::get('tab') == 'attachment') ? 'true' : 'false' }}">{{$language::get('attachment')}}</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ (!\Session::has('tab') || (\Session::has('tab') && \Session::get('tab') == 'data')) ? 'show active' : '' }}" id="data" role="tabpanel" aria-labelledby="data-tab">
            @include('logged.request.form')
        </div>
        <div class="tab-pane fade {{ (\Session::has('tab') && \Session::get('tab') == 'progress') ? 'show active' : '' }}" id="progress" role="tabpanel" aria-labelledby="progress-tab">
            @include('logged.request.progress')
        </div>
        <div class="tab-pane fade {{ (\Session::has('tab') && \Session::get('tab') == 'attachment') ? 'show active' : '' }}" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
            @include('logged.request.attachment')
        </div>
    </div>

</div>

@endsection
