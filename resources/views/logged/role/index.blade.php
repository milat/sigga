@extends('layouts.app')

@section('content')

    <div class="container mt-2 pt-2">

        <div class="row mb-3">
            <div class="col">
                <h2>{{$language::get('roles')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-8 col-md-10">
                <div class="form-group">
                    <input type="text" class="form-control" url="{{route('role.search')}}/" id="search" placeholder="{{$language::get('search')}} {{strtolower($language::get('role'))}}" />
                </div>
            </div>
            <div class="col-4 col-md-2">
                <a href="{{route('role.create')}}">
                    <button type="button" class="btn btn-primary btn-block">{{$language::get('create')}}</button>
                </a>
            </div>
        </div>

        <div id="result"></div>

        <img class="loading-gif" src="{{ asset('images/loading.gif') }}" />
    </div>

@endsection
