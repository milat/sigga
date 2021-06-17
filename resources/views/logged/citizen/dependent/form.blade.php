@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $dependent ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('dependent'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $dependent ? route('citizen.dependent.update', [$citizen->id, $dependent->id]) : route('citizen.dependent.insert', $citizen->id) }}">

                @csrf

                @if ($dependent)
                    @method('PUT')
                @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="dependent_citizen" class="required">{{$language::get('dependent_citizen_id')}}</label>
                                <input type="text" readonly='true' class="form-control" id="dependent_citizen" name="dependent_citizen" value="{{$citizen->name}} - {{$language::get('citizen_identity_document')}}: {{$citizen->identity_document}}">
                                <input type="hidden" name="dependent_citizen_id" value="{{$citizen->id}}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="dependent_name" class="required">{{$language::get('dependent_name')}}</label>
                                <input type="text" class="form-control @error('dependent_name') is-invalid @enderror" id="dependent_name" name="dependent_name" maxlength="100" placeholder="{{$language::get('dependent_name_placeholder')}}" value="{{$dependent ? $dependent->name : old('dependent_name')}}">
                                @error('dependent_name')
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
                                <label for="dependent_identity_document">{{$language::get('dependent_identity_document')}}</label>
                                <input type="text" class="form-control @error('dependent_identity_document') is-invalid @enderror" id="dependent_identity_document" name="dependent_identity_document" maxlength="20" placeholder="{{$language::get('dependent_identity_document_placeholder')}}" value="{{$dependent ? $dependent->identity_document : old('dependent_identity_document')}}">
                                @error('dependent_identity_document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="dependent_birth" class="required">{{$language::get('dependent_birth')}}</label>
                                <input type="date" class="form-control @error('dependent_birth') is-invalid @enderror" id="dependent_birth" name="dependent_birth" placeholder="{{$language::get('dependent_birth_placeholder')}}" value="{{$dependent ? $dependent->birth : old('dependent_birth')}}">
                                @error('dependent_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="dependent_is_active" class="required">{{$language::get('dependent_is_active')}}</label>
                                <select id="dependent_is_active" class="form-control combo @error('dependent_is_active') is-invalid @enderror" name="dependent_is_active">
                                    <option value='1' {{(($dependent && $dependent->is_active) || (old('dependent_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($dependent &&  !$dependent->is_active) || (old('dependent_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('dependent_is_active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </fieldset>

                @include('logged.phone.form')

                <fieldset>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="dependent_note">{{$language::get('dependent_note')}}</label>
                                <textarea class="form-control" id="dependent_note" name="dependent_note" rows="2">{{$dependent ? $dependent->note : old('dependent_note')}}</textarea>
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
                        <a href="{{route('citizen.dependent', $citizen->id)}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $dependent ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('citizen.dependent', $citizen->id)}}">
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
