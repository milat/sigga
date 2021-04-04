@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $organization ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('organization'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" autocomplete="off" action="{{ $organization ? route('organization.update', $organization->id) : route('organization.insert') }}">

                @csrf

                @if ($organization)
                    @method('PUT')
                @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="organization_trade" class="required">{{$language::get('organization_trade')}}</label>
                                <input type="text" class="form-control @error('organization_trade') is-invalid @enderror" id="organization_trade" name="organization_trade" maxlength="30" placeholder="{{$language::get('organization_trade_placeholder')}}" value="{{$organization ? $organization->trade : old('organization_trade')}}">
                                @error('organization_trade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="organization_name">{{$language::get('organization_name')}}</label>
                                <input type="text" class="form-control @error('organization_name') is-invalid @enderror" id="organization_name" name="organization_name" maxlength="100" placeholder="{{$language::get('organization_name_placeholder')}}" value="{{$organization ? $organization->name : old('organization_name')}}">
                                @error('organization_name')
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
                                <label for="organization_contact" class="required">{{$language::get('organization_contact')}}</label>
                                <input type="text" class="form-control @error('organization_contact') is-invalid @enderror" id="organization_contact" name="organization_contact" maxlength="100" placeholder="{{$language::get('organization_contact_placeholder')}}" value="{{$organization ? $organization->contact : old('organization_contact')}}">
                                @error('organization_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="organization_branch">{{$language::get('organization_branch')}}</label>
                                <select id="organization_branch" class="form-control combo_tag @error('organization_branch') is-invalid @enderror" name="organization_branch">
                                    <option></option>
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->branch}}" {{(($organization && $organization->branch == $branch->branch) || (old('organization_branch') == $branch->branch)) ? 'selected' : ''}}>{{$branch->branch}}</option>
                                    @endforeach
                                </select>

                                @error('organization_branch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="organization_identity_document">{{$language::get('organization_identity_document')}}</label>
                                <input type="text" class="form-control cnpj @error('organization_identity_document') is-invalid @enderror" id="organization_identity_document" maxlength="30" name="organization_identity_document" placeholder="{{$language::get('organization_identity_document_placeholder')}}" value="{{$organization ? $organization->identity_document : old('organization_identity_document')}}">
                                @error('organization_identity_document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="organization_email">{{$language::get('organization_email')}}</label>
                                <input type="email" class="form-control @error('organization_email') is-invalid @enderror" id="organization_email" name="organization_email" maxlength="100" placeholder="{{$language::get('organization_email_placeholder')}}" value="{{$organization ? $organization->email : old('organization_email')}}">
                                @error('organization_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="organization_is_active" class="required">{{$language::get('organization_is_active')}}</label>
                                <select id="organization_is_active" class="form-control combo @error('organization_is_active') is-invalid @enderror" name="organization_is_active">
                                    <option value='1' {{(($organization && $organization->is_active) || (old('organization_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($organization &&  !$organization->is_active) || (old('organization_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('organization_is_active')
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
                                <label for="organization_note">{{$language::get('organization_note')}}</label>
                                <textarea class="form-control" id="organization_note" name="organization_note" rows="2">{{$organization ? $organization->note : old('organization_note')}}</textarea>
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
                    <!-- Only for medium or larger screens -->
                    <div class="col-md-2 d-none d-md-block">
                        <a href="{{route('organization.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $organization ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('organization.index')}}">
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
