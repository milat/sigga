@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>
                {{ $user ? $language::get('edit') : $language::get('create')}}
                {{strtolower($language::get('user'))}}
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $user ? route('user.update', $user->id) : route('user.insert') }}">

                @csrf

                @if($user)
                    @method('PUT')
                @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="user_name" class="required">{{$language::get('user_name')}}</label>
                                <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" maxlength="100" placeholder="{{$language::get('user_name_placeholder')}}" value="{{$user ? $user->name : old('user_name')}}">
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="user_email" class="required">{{$language::get('user_email')}}</label>
                                <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" name="user_email" maxlength="100" placeholder="{{$language::get('user_email_placeholder')}}" value="{{$user ? $user->email : old('user_email')}}">
                                @error('user_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="user_identity_document">{{$language::get('user_identity_document')}}</label>
                                <input type="text" class="form-control cpf @error('user_identity_document') is-invalid @enderror" id="user_identity_document" maxlength="20" name="user_identity_document" placeholder="{{$language::get('user_identity_document_placeholder')}}" value="{{$user ? $user->identity_document : old('user_identity_document')}}">
                                @error('user_identity_document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="user_role_id" class="required">{{$language::get('user_role_id')}}</label>
                                <select id="user_role_id" class="form-control combo @error('user_role_id') is-invalid @enderror" name="user_role_id">
                                    <option></option>
                                    @foreach ($roles as $role)
                                    <option {{(($user && $user->role_id == $role->id) || (old('user_role_id') == $role->id)) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('user_role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="user_is_active" class="required">{{$language::get('user_is_active')}}</label>
                                <select id="user_is_active" class="form-control combo @error('user_is_active') is-invalid @enderror" name="user_is_active">
                                    <option value='1' {{(($user && $user->is_active) || (old('user_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($user && !$user->is_active) || (old('user_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('user_is_active')
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
                        <a href="{{route('user.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $user ? $language::get('update') : $language::get('insert')}}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('user.index')}}">
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
