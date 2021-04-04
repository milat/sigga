<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{$language::get('citizen_name')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$citizen->name}}" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{$language::get('citizen_email')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$citizen->email}}" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>{{$language::get('citizen_identity_document')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$citizen->identity_document}}" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>{{$language::get('citizen_birth')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{ $citizen->birth ? date('d/m/Y', strtotime($citizen->birth)) : '' }}" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>{{$language::get('citizen_is_active')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$citizen->is_active ? $language::get('active') : $language::get('inactive')}}" />
        </div>
    </div>
</div>

<hr />

@include('logged.phone.view')

<hr />

@include('logged.address.view')

@if ($citizen->note)
    <hr />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{$language::get('citizen_note')}}</label>
                <textarea class="form-control" disabled="true">{{$citizen->note}}</textarea>
            </div>
        </div>
    </div>
@endif