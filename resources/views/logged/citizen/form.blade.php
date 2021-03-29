@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $citizen ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('citizen'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $citizen ? route('citizen.update', $citizen->id) : route('citizen.insert') }}">

                @csrf

                @if ($citizen)
                    @method('PUT')
                @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="citizen_name" class="required">{{$language::get('citizen_name')}}</label>
                                <input type="text" class="form-control @error('citizen_name') is-invalid @enderror" id="citizen_name" name="citizen_name" maxlength="100" placeholder="{{$language::get('citizen_name_placeholder')}}" value="{{$citizen ? $citizen->name : old('citizen_name')}}">
                                @error('citizen_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="citizen_email">{{$language::get('citizen_email')}}</label>
                                <input type="email" class="form-control @error('citizen_email') is-invalid @enderror" id="citizen_email" name="citizen_email" maxlength="100" placeholder="{{$language::get('citizen_email_placeholder')}}" value="{{$citizen ? $citizen->email : old('citizen_email')}}">
                                @error('citizen_email')
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
                                <label for="citizen_identity_document" class="required">{{$language::get('citizen_identity_document')}}</label>
                                <input type="text" class="form-control cpf @error('citizen_identity_document') is-invalid @enderror" id="citizen_identity_document" name="citizen_identity_document" maxlength="20" placeholder="{{$language::get('citizen_identity_document_placeholder')}}" value="{{$citizen ? $citizen->identity_document : old('citizen_identity_document')}}">
                                @error('citizen_identity_document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="citizen_birth">{{$language::get('citizen_birth')}}</label>
                                <input type="date" class="form-control @error('citizen_birth') is-invalid @enderror" id="citizen_birth" name="citizen_birth" placeholder="{{$language::get('citizen_birth_placeholder')}}" value="{{$citizen ? $citizen->birth : old('citizen_birth')}}">
                                @error('citizen_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="citizen_is_active" class="required">{{$language::get('citizen_is_active')}}</label>
                                <select id="citizen_is_active" class="form-control combo @error('citizen_is_active') is-invalid @enderror" name="citizen_is_active">
                                <option value='1' {{(($citizen && $citizen->is_active) || (old('citizen_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($citizen &&  !$citizen->is_active) || (old('citizen_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('citizen_is_active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </fieldset>

                @include('logged.phone.form')

                @include('logged.address.form')

                <fieldset>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="citizen_note">{{$language::get('citizen_note')}}</label>
                                <textarea class="form-control" id="citizen_note" name="citizen_note" rows="2">{{$citizen ? $citizen->note : old('citizen_note')}}</textarea>
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
                        <a href="{{route('citizen.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $citizen ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
