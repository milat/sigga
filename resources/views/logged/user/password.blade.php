@extends('layouts.app')

@section('content')

    <div class="container mt-2 pt-2">

        <div class="row mb-3">
            <div class="col">
                <h2>{{ $language::get('password_update') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('user.password.action') }}">

                    @csrf
                    @method('PUT')

                    <fieldset>

                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password_current" class="required">{{$language::get('password_current')}}</label>
                                    <input type="password" class="form-control @error('password_current') is-invalid @enderror" id="password_current" name="password_current" maxlength="100" placeholder="{{$language::get('password_current_placeholder')}}">
                                    @error('password_current')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password_new" class="required">{{$language::get('password_new')}}</label>
                                    <input type="password" class="form-control @error('password_new') is-invalid @enderror" id="password_new" name="password_new" maxlength="100" placeholder="{{$language::get('password_new_placeholder')}}">
                                    @error('password_new')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password_confirm" class="required">{{$language::get('password_confirm')}}</label>
                                    <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" id="password_confirm" name="password_confirm" maxlength="100" placeholder="{{$language::get('password_confirm_placeholder')}}">
                                    @error('password_confirm')
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

                    <div class="form-group row mt-5 justify-content-md-center">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{$language::get('update')}}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
