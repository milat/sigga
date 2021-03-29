@extends('layouts.app')

@section('content')

    @can ('dashboard')
        <div class="container mt-2 pt-2">

            <div class="row mb-3">
                <div class="col">
                    <h2>{{$language::get('dashboard')}}</h2>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-md-6 mt-4">
                    @include('logged.home.graphics.statusMonth')
                </div>
                <div class="col-12 col-md-6 mt-4">
                    @include('logged.home.graphics.categoryMonth')
                </div>
            </div>

            <div class="row mt-3">
                @if ($data['status']['month'] != $data['status']['year'])
                    <div class="col-12 col-md-6 mt-4">
                        @include('logged.home.graphics.statusYear')
                    </div>
                @endif
                @if ($data['categories']['month'] != $data['categories']['year'])
                    <div class="col-12 col-md-6 mt-4">
                        @include('logged.home.graphics.categoryYear')
                    </div>
                @endif
            </div>

        </div>
    @else
        <div class="container mt-2 pt-2">

            <div class="row mb-3">
                <div class="col">
                    <h2>Sigga</h2>
                </div>
            </div>

        </div>
    @endcan

@endsection
