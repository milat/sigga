@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $role ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('role'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $role ? route('role.update', $role->id) : route('role.insert') }}">

                @csrf

                @if ($role)
                    @method('PUT')
                @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <label for="role_name" class="required">{{$language::get('role_name')}}</label>
                                <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" maxlength="15" placeholder="{{$language::get('role_name_placeholder')}}" value="{{$role ? $role->name : old('role_name')}}">
                                @error('role_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="role_is_active" class="required">{{$language::get('role_is_active')}}</label>
                                <select id="role_is_active" class="form-control combo @error('role_is_active') is-invalid @enderror" name="role_is_active">
                                    <option value='1' {{(($role && $role->is_active) || (old('role_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($role && !$role->is_active) || (old('role_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('role_is_active')
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
                        <a href="{{route('role.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $role ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
