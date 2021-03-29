@extends('layouts.app')

@section('content')

    <div class="container mt-2 pt-2">

        <div class="row mb-3">
            <div class="col">
                <h2>{{ $language::get('users') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-8 col-md-10">
                <div class="form-group">
                    <input type="text" class="form-control" id="search" url="{{route('user.search')}}/" placeholder="{{ $language::get('search') }} {{ strtolower($language::get('user')) }}" />
                </div>
            </div>
            <div class="col-4 col-md-2">
                @can('user.insert')
                    <a href="{{route('user.create')}}">
                        <button type="button" class="btn btn-primary btn-block">{{ $language::get('create') }}</button>
                    </a>
                @endcan
            </div>
        </div>

        <div id="result"></div>

        <img class="loading-gif" src="{{ asset('images/loading.gif') }}" />
    </div>

@endsection
