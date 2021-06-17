@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $document ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('document'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data" action="{{ $document ? route('document.update', $document->id) : route('document.insert') }}">

                @csrf
                @if ($document) @method('PUT') @endif

                <fieldset>

                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group">
                                <label for="document_type_id" class='required'>{{$language::get('document_type_id')}}</label>
                                <select id="document_type_id" class="form-control combo @error('document_type_id') is-invalid @enderror" name="document_type_id">
                                    @foreach ($types as $type)
                                        <option {{ $document && $document->document_type_id == $type->id ? 'selected' :  old('document_type_id') == $type->id ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('document_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group">
                                <label for="document_code" class="required">{{$language::get('document_code')}}</label>
                                <input type="text" class="form-control document_number @error('document_code') is-invalid @enderror" id="document_code" name="document_code" maxlength="20" placeholder="{{$language::get('document_code_placeholder')}}" value="{{$document ? $document->code : old('document_code')}}">
                                @error('document_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-2">
                            <div class="form-group">
                                <label for="document_date" class="required">{{$language::get('document_date')}}</label>
                                <input type="date" class="form-control @error('document_date') is-invalid @enderror" id="document_date" name="document_date" placeholder="{{$language::get('document_date_placeholder')}}" value="{{$document ? $document->date : old('document_date') ?? date('Y-m-d')}}">
                                @error('document_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="file" class="{{ $document ? '' : 'required' }}">{{$language::get('file')}}</label>
                                <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="document_title" class="required">{{$language::get('document_title')}}</label>
                                <textarea class="form-control @error('document_title') is-invalid @enderror" id="document_title" name="document_title" rows="2">{{$document ? $document->title : old('document_title')}}</textarea>
                                @error('document_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="document_note">{{$language::get('document_note')}}</label>
                                <textarea class="form-control" id="document_note" name="document_note" rows="2">{{$document ? $document->note : old('document_note')}}</textarea>
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
                        <a href="{{route('document.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $document ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('document.index')}}">
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
