@extends('layouts.app')

@section('content')

    <div class="container mt-2 pt-2">

        <div class="row mb-3">
            <div class="col">
                <h2>{{$language::get('activity_classes')}}</h2>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-10">
                <div class="form-group">
                    <input type="text" class="form-control" url="{{route('activity_class.search')}}/" id="search" placeholder="{{$language::get('search')}} {{strtolower($language::get('activity_class'))}}" />
                </div>
            </div>
            @can('activity_class.insert')
                <div class="col-12 col-md-4 col-lg-2">
                    <a href="{{route('activity_class.create')}}">
                        <button type="button" class="btn btn-primary btn-block">{{$language::get('create')}}</button>
                    </a>
                </div>
            @endcan
        </div>

        <div id="result"></div>

        <img class="loading-gif" src="{{ asset('images/loading.gif') }}" />
    </div>

@endsection
