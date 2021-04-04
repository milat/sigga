<div class="row">
    <div class="col-md-12">
        <fieldset>
            @can ('request.update')
                <div class="row">
                    <div class="col-12 col-md-6 offset-lg-4 col-lg-4">
                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#documentModal">
                            {{$language::get('link_existing_document')}}
                        </button>
                        <div class="mb-3 d-block d-md-none"></div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#newDocumentModal">
                            {{$language::get('create')}} {{strtolower($language::get('new'))}} {{strtolower($language::get('document'))}}
                        </button>
                    </div>
                </div>
                <hr />
            @endcan

            @if ($request->document)
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>{{$language::get('document_type_id')}}</label>
                            <input type="text" class="form-control" value="{{$request->document->type->name}}" disabled="true">
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>{{$language::get('document_code')}}</label>
                            <input type="text" class="form-control" value="{{$request->document->code}}" disabled="true">
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>{{$language::get('document_date')}}</label>
                            <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($request->document->date)) }}" disabled="true">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>{{$language::get('document_title')}}</label>
                            <textarea class="form-control" rows="2" disabled="true">{{$request->document->title}}</textarea>
                        </div>
                    </div>
                </div>

                @if ($request->document->note)
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="document_note">{{$language::get('document_note')}}</label>
                                <textarea class="form-control" rows="2" disabled="true">{{$request->document->note}}</textarea>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-md-center mt-3">
                    <div class="col-12 col-md-3 col-lg-2">
                        <a href="{{route('document.download', $request->document->id)}}" title="{{$language::get('download')}} {{strtolower($language::get('document'))}} '{{$request->document->code}}'">
                            <button class="btn btn-primary btn-block">
                                {{$language::get('download')}} <x-bi-file-earmark-arrow-down/>
                            </button>
                        </a>
                    </div>
                </div>
            @else
                {{$language::get('request_no_document_linked')}}
            @endif
        </fieldset>
    </div>
</div>

@can ('request.update')
    <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('request.link', $request->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{$language::get('link_existing_document')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select class="document_combo form-control" name="document_id" src="{{route('document.combo')}}">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            @if ($request->status_id != config('request_statuses.sent.id'))
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="update_status" name="update_status" checked="true" value="1">
                                        <label class="form-check-label" for="update_status">{{$language::get('update_status_after_link')}}</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($request->document)
                            <div class="row">
                                <div class="col-12">
                                    <small>{{$language::get('replacing_request_document')}}</small>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            {{$language::get('link')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newDocumentModal" tabindex="-1" role="dialog" aria-labelledby="newDocumentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data" action="{{ route('request.document', $request->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            {{$language::get('create')}} {{strtolower($language::get('new'))}} {{strtolower($language::get('document'))}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="document_type_id" class='required'>{{$language::get('document_type_id')}}</label>
                                    <select id="document_type_id" class="form-control combo @error('document_type_id') is-invalid @enderror" name="document_type_id">
                                        @foreach ($types as $type)
                                            <option {{ old('document_type_id') == $type->id ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('document_type_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="document_code" class="required">{{$language::get('document_code')}}</label>
                                    <input type="text" class="form-control document_number @error('document_code') is-invalid @enderror" id="document_code" name="document_code" maxlength="20" placeholder="{{$language::get('document_code_placeholder')}}" value="{{old('document_code')}}">
                                    @error('document_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="document_date" class="required">{{$language::get('document_date')}}</label>
                                    <input type="date" class="form-control @error('document_date') is-invalid @enderror" id="document_date" name="document_date" placeholder="{{$language::get('document_date_placeholder')}}" value="{{old('document_date') ?? date('Y-m-d')}}">
                                    @error('document_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="document_file" class="required">{{$language::get('document_file')}}</label>
                                    <input type="file" class="form-control-file" id="document_file" name="document_file">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="document_title" class="required">{{$language::get('document_title')}}</label>
                                    <textarea class="form-control" id="document_title" name="document_title" rows="2">{{old('document_title')}}</textarea>
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
                                    <textarea class="form-control" id="document_note" name="document_note" rows="2">{{old('document_note')}}</textarea>
                                </div>
                            </div>
                            @if ($request->status_id != config('request_statuses.sent.id'))
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="update_status" name="update_status" checked="true" value="1">
                                        <label class="form-check-label" for="update_status">{{$language::get('update_status_after_link')}}</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($request->document)
                            <div class="row">
                                <div class="col-12">
                                    <small>{{$language::get('replacing_request_document')}}</small>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            {{$language::get('insert')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan