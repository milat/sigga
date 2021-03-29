@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col">
            <h2>{{ $category ? $language::get('edit') : $language::get('create') }} {{strtolower($language::get('category'))}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ $category ? route('category.update', $category->id) : route('category.insert') }}">

                @csrf
                @if ($category) @method('PUT') @endif

                <fieldset>

                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="category_name" class="required">{{$language::get('category_name')}}</label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" placeholder="{{$language::get('category_name_placeholder')}}" maxlength="20" value="{{$category ? $category->name : old('category_name')}}">
                                @error('category_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="col-12 col-md-1">
                            <div class="form-group">
                                <label for="cor">{{$language::get('category_colour')}}:</label>
                                <input type="color" class="form-control" id="cor" name="cor" value="{{$category ? $category->colour : '#f8f9fa'}}">
                            </div>
                        </div> -->
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="category_is_active" class="required">{{$language::get('category_is_active')}}</label>
                                <select id="category_is_active" class="form-control combo @error('category_is_active') is-invalid @enderror" name="category_is_active">
                                    <option value='1' {{(($category && $category->is_active) || (old('category_is_active') == '1')) ? 'selected' : ''}}>{{$language::get('active')}}</option>
                                    <option value='0' {{(($category && !$category->is_active) || (old('category_is_active'))) ? 'selected' : ''}}>{{$language::get('inactive')}}</option>
                                </select>
                                @error('category_is_active')
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
                        <a href="{{route('category.index')}}">
                            <button type="button" class="btn btn-outline-secondary btn-block">
                                {{$language::get('return')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $category ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
