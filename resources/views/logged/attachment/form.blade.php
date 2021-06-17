@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $attachment ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('attachment'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data" action="{{ $attachment ? route('attachment.update', $attachment->id) : route('attachment.insert') }}">

                @csrf
                @if ($attachment) @method('PUT') @endif

                <fieldset>

                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-3 col-xl-2">
                            <div class="form-group">
                                <label for="attachment_date" class="required">{{$language::get('attachment_date')}}</label>
                                <input type="date" class="form-control @error('attachment_date') is-invalid @enderror" id="attachment_date" name="attachment_date" placeholder="{{$language::get('attachment_date_placeholder')}}" value="{{$attachment ? $attachment->date : old('attachment_date') ?? date('Y-m-d')}}">
                                @error('attachment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="file" class="{{ $attachment ? '' : 'required' }}">{{$language::get('file')}}</label>
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
                                <label for="attachment_title" class="required">{{$language::get('attachment_title')}}</label>
                                <input type="text" class="form-control @error('attachment_title') is-invalid @enderror" id="attachment_title" name="attachment_title" maxlength="100" placeholder="{{$language::get('attachment_title_placeholder')}}" value="{{$attachment ? $attachment->title : old('attachment_title')}}">
                                @error('attachment_title')
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
                                <label for="attachment_note">{{$language::get('attachment_note')}}</label>
                                <textarea class="form-control" id="attachment_note" name="attachment_note" rows="2">{{$attachment ? $attachment->note : old('attachment_note')}}</textarea>
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
                        <a href="{{route('attachment.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $attachment ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('attachment.index')}}">
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
