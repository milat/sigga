@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{$language::get('create')}} {{strtolower($language::get('activity_subscriber'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('activity_class.subscriber.insert', $class->id) }}">

                @csrf

                <fieldset>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="subscriber_owner" class='required'>{{$language::get('activity_subscriber_name')}}</label>
                                <select id="subscriber_owner" class="form-control combo @error('subscriber_owner') is-invalid @enderror" name="subscriber_owner">
                                    <option></option>
                                    @foreach ($nonSubscribers as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                @error('subscriber_owner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </fieldset>

                <div class="row">
                    <div class="col">
                        <small class="required-legend"></small>
                    </div>
                </div>

                <div class="form-group row mt-3 justify-content-md-center">
                    <!-- Only for medium or larger screens -->
                    <div class="col-md-2 d-none d-md-block">
                        <a href="{{route('activity_class.subscriber', $class->id)}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('activity_class.subscriber', $class->id)}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
