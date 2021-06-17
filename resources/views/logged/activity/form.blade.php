@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $activity ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('activity'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $activity ? route('activity.update', $activity->id) : route('activity.insert') }}">

                @csrf
                @if ($activity) @method('PUT') @endif

                <fieldset>

                    <div class="row">

                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="activity_name" class="required">{{$language::get('activity_name')}}</label>
                                <input type="text" class="form-control @error('activity_name') is-invalid @enderror" id="activity_name" name="activity_name" placeholder="{{$language::get('activity_name_placeholder')}}" value="{{$activity ? $activity->name : old('activity_name')}}">
                                @error('activity_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="activity_is_active" class="required">{{$language::get('activity_is_active')}}</label>
                                <select id="activity_is_active" class="form-control combo @error('activity_is_active') is-invalid @enderror" name="activity_is_active">
                                    <option value='1' {{(($activity && $activity->is_active) || (old('activity_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($activity &&  !$activity->is_active) || (old('activity_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('activity_is_active')
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
                                <label for="activity_description">{{$language::get('activity_description')}}</label>
                                <textarea class="form-control" id="activity_description" name="activity_description" rows="2">{{$activity ? $activity->description : old('activity_description')}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="activity_note">{{$language::get('activity_note')}}</label>
                                <textarea class="form-control" id="activity_note" name="activity_note" rows="2">{{$activity ? $activity->note : old('activity_note')}}</textarea>
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
                        <a href="{{route('activity.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $activity ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('activity.index')}}">
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
