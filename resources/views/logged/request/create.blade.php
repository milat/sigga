@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{$language::get('create')}} {{$language::get('request')}}</h2>
        </div>
    </div>

    @include('logged.request.form')

</div>

@endsection
