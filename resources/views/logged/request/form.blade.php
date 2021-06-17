<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{ $request ? route('request.update', $request->id) : route('request.insert') }}">

            @csrf

            @if ($request)
                @method('PUT')
            @endif

            <fieldset>

                @if ($request)
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="requester" class='required'>{{$language::get('request_requester')}}</label>
                                <div class="input-group">
                                    <input type="text" disabled="true" class="form-control" id="solicitante" value="{{$request->owner->name}} ({{$language::get($text::getClassName($request->owner))}})">
                                    <button class="btn btn-outline-secondary view" data-title="{{$request->owner->name}} ({{$language::get($text::getClassName($request->owner))}})" url="{{route($text::getClassName($request->owner).'.view', $request->owner->id)}}" type="button" title="{{$language::get('view_me')}}">
                                        <x-bi-eye/>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="request_responsible" class='required'>{{$language::get('request_responsible')}}</label>
                                <input type="text" disabled="true" class="form-control" id="request_responsible" value="{{$request->updater->email}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="request_created_at" class='required'>{{$language::get('request_created_at')}}</label>
                                <input type="text" disabled="true" class="form-control" id="request_created_at" value="{{ date('d/m/Y - H:i:s', strtotime($request->created_at)) }}">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="request_owner_id" class='required'>{{$language::get('request_owner_id')}}</label>
                                <select id="request_owner_id" class="form-control combo @error('request_owner_id') is-invalid @enderror" name="request_owner_id">
                                    <option></option>
                                    <optgroup label="{{$language::get('citizens')}}" />
                                    @foreach ($citizens as $citizen)
                                        <option {{ old('request_owner_id') == get_class($citizen).'_'.$citizen->id ? 'selected' :  '' }} value="{{get_class($citizen)}}_{{$citizen->id}}">{{$citizen->name}} ({{$citizen->identity_document}})</option>
                                    @endforeach
                                    <optgroup label="{{$language::get('organizations')}}" />
                                    @foreach ($organizations as $organization)
                                        <option {{ old('request_owner_id') == get_class($organization).'_'.$organization->id ? 'selected' :  '' }} value="{{get_class($organization)}}_{{$organization->id}}">{{$organization->trade}} ({{$language::get('organization_contact')}}: {{$organization->contact}}{{$organization->identity_document ? '; '.$organization->identity_document.';' : ''}})</option>
                                    @endforeach
                                    <optgroup label="{{$language::get('users')}}" />
                                    @foreach ($users as $user)
                                        <option {{ old('request_owner_id') == get_class($user).'_'.$user->id ? 'selected' :  '' }} value="{{get_class($user)}}_{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                                    @endforeach
                                </select>
                                @error('request_owner_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="request_category_id" class='required'>{{$language::get('request_category_id')}}</label>
                            <select id="request_category_id" class="form-control combo @error('request_category_id') is-invalid @enderror" name="request_category_id" {{($request && Auth::user()->cant('request.update')) ? 'disabled' : '' }}>
                                <option></option>
                                @foreach ($categories as $category)
                                    <option {{ (($request && $request->category_id == $category->id) || (old('request_category_id') == $category->id)) ? 'selected' :  '' }} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('request_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="request_status_id" class='required'>{{$language::get('request_status_id')}}</label>
                            <select id="request_status_id" class="form-control combo @error('request_status_id') is-invalid @enderror" name="request_status_id" {{($request && Auth::user()->cant('request.update')) ? 'disabled' : '' }}>
                                @foreach ($status as $st)
                                    <option {{ (($request && $request->status_id == $st->id) || (old('request_status_id') == $st->id)) ? 'selected' :  '' }} value="{{$st->id}}">{{$st->name}}</option>
                                @endforeach
                            </select>
                            @error('request_status_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="request_place">{{$language::get('request_place')}}</label>
                            <input type="text" class="form-control @error('request_place') is-invalid @enderror" id="request_place" name="request_place" maxlength="150" placeholder="{{$language::get('request_place_placeholder')}}" value="{{$request ? $request->place : old('request_place')}}" {{($request && Auth::user()->cant('request.update')) ? 'disabled' : '' }}>
                            @error('request_place')
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
                            <label for="request_title" class='required'>{{$language::get('request_title')}}</label>
                            <input type="text" class="form-control @error('request_title') is-invalid @enderror" id="request_title" name="request_title" maxlength="100" placeholder="{{$language::get('request_title_placeholder')}}" value="{{$request ? $request->title : old('request_title')}}" {{($request && Auth::user()->cant('request.update')) ? 'disabled' : '' }}>
                            @error('request_title')
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
                            <label for="request_description" class='required'>{{$language::get('request_description')}}</label>
                            <textarea class="form-control @error('request_description') is-invalid @enderror" id="request_description" name="request_description" rows="2" {{($request && Auth::user()->cant('request.update')) ? 'disabled' : '' }}>{{$request ? $request->description : old('request_description')}}</textarea>
                            @error('request_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                @include('logged.request.whatsapp')
            </fieldset>

            @if (($request && Auth::user()->can('request.update')) || !$request)

                <div class="row">
                    <div class="col">
                        <small class="required-legend"></small>
                    </div>
                </div>

            @endif

            <div class="form-group row mt-3 justify-content-md-center">
                <!-- Only for medium or larger screens -->
                <div class="col-md-2 d-none d-md-block">
                    <a href="{{route('request.index')}}">
                        <button type="button" class="btn btn-outline-secondary btn-block">
                            {{$language::get('return')}}
                        </button>
                    </a>
                </div>

                @if (($request && Auth::user()->can('request.update')) || !$request)
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $request ? $language::get('update') : $language::get('insert') }}
                        </button>
                    </div>
                @endif
            </div>

            <!-- Only for small screens -->
            <div class="form-group row mt-4 justify-content-md-center">
                <div class="col-md-2 d-block d-md-none">
                    <a href="{{route('request.index')}}">
                        <button type="button" class="btn btn-outline-secondary btn-block">
                            {{$language::get('return')}}
                        </button>
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

@include('logged.common.modal')
@include('logged.request.script_view_requester')