@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $class ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('activity_class'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $class ? route('activity_class.update', $class->id) : route('activity_class.insert') }}">

                @csrf
                @if ($class) @method('PUT') @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="activity_id" class='required'>{{$language::get('activity')}}</label>
                                <select id="activity_id" class="form-control combo @error('activity_id') is-invalid @enderror" name="activity_id">
                                    <option></option>
                                    @foreach ($activities as $activity)
                                        <option {{ (old('activity_id') == $activity->id || ($class && $class->activity_id == $activity->id)) ? 'selected' : '' }} value="{{$activity->id}}">{{$activity->name}}</option>
                                    @endforeach
                                </select>
                                @error('activity_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="activity_class_responsible_user_id" class='required'>{{$language::get('activity_class_responsible_user_id')}}</label>
                                <select id="activity_class_responsible_user_id" class="form-control combo @error('activity_class_responsible_user_id') is-invalid @enderror" name="activity_class_responsible_user_id">
                                    <option></option>
                                    @foreach ($responsibles as $responsible)
                                        @if ($responsible->hasPermission('activity_lesson'))
                                            <option {{ (old('activity_class_responsible_user_id') == $responsible->id || ($class && $class->responsible_user_id == $responsible->id)) ? 'selected' : '' }} value="{{$responsible->id}}">{{$responsible->name}} ({{$responsible->role->name}})</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('activity_class_responsible_user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="activity_class_place">{{$language::get('activity_class_place')}}</label>
                                <input type="text" class="form-control @error('activity_class_place') is-invalid @enderror" id="activity_class_place" name="activity_class_place" maxlength="20" placeholder="{{$language::get('activity_class_place_placeholder')}}" value="{{$class ? $class->place : old('activity_class_place')}}">
                                @error('activity_class_place')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="activity_class_max_subscribers">{{$language::get('activity_class_max_subscribers')}}</label>
                                <input type="text" class="form-control @error('activity_class_max_subscribers') is-invalid @enderror" id="activity_class_max_subscribers" name="activity_class_max_subscribers" maxlength="20" placeholder="{{$language::get('activity_class_max_subscribers_placeholder')}}" value="{{$class ? $class->max_subscribers : old('activity_class_max_subscribers')}}">
                                @error('activity_class_max_subscribers')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="activity_class_is_active" class="required">{{$language::get('activity_class_is_active')}}</label>
                                <select id="activity_class_is_active" class="form-control combo @error('activity_class_is_active') is-invalid @enderror" name="activity_class_is_active">
                                    <option value='1' {{(($class && $class->is_active) || (old('activity_class_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($class &&  !$class->is_active) || (old('activity_class_is_active') == '0')) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('activity_class_is_active')
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
                                <label for="activity_class_schedule">{{$language::get('activity_class_schedule')}}</label>
                                <textarea class="form-control" id="activity_class_schedule" name="activity_class_schedule" rows="1">{{$class ? $class->schedule : old('activity_class_schedule')}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="activity_class_note">{{$language::get('activity_class_note')}}</label>
                                <textarea class="form-control" id="activity_class_note" name="activity_class_note" rows="2">{{$class ? $class->note : old('activity_class_note')}}</textarea>
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
                        <a href="{{route('activity_class.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $class ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

                <!-- Only for small screens -->
                <div class="form-group row mt-4 justify-content-md-center">
                    <div class="col-md-2 d-block d-md-none">
                        <a href="{{route('activity_class.index')}}">
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
