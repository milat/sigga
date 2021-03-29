@extends('layouts.adm')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">GABINETES</div>

                <div class="card-body">
                    @if (Auth::guard('admin')->check())
                        {{Auth::guard('admin')->user()->email}}
                    @else
                        {{'nfo'}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
