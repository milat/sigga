@extends('layouts.app')

@section('content')

    <div class="container mt-2 pt-2">

        <div class="row mb-3">
            <div class="col">
                <h2>{{$language::get('requests')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-4 col-md-8">
                <div class="form-group">
                    <input type="text" class="form-control" id="request_search" placeholder="{{$language::get('search')}} {{strtolower($language::get('requests'))}}" />
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <select id="status_id" class="form-control combo @error('status_id') is-invalid @enderror" name="status_id">
                        <option value="0">{{$language::get('all')}} {{strtolower($language::get('request_status_id'))}}</option>
                        @foreach ($status as $st)
                            <option value="{{$st->id}}">{{$st->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4 col-md-2">
                @can('request.insert')
                    <a href="{{route('request.create')}}">
                        <button type="button" class="btn btn-primary btn-block">{{$language::get('create')}}</button>
                    </a>
                @endcan
            </div>
        </div>

        <div id="requests"></div>

        <img class="loading-gif" src="{{ asset('images/loading.gif') }}" />
    </div>

    @include('logged.request.script')

@endsection
