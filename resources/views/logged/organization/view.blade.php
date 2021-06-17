<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label>{{$language::get('organization_name')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$organization->name}}" />
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>{{$language::get('citizen_email')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$organization->email}}" />
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>{{$language::get('organization_contact')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$organization->contact}}" />
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>{{$language::get('organization_branch')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$organization->branch}}" />
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>{{$language::get('organization_identity_document')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$organization->identity_document}}" />
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>{{$language::get('organization_is_active')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$organization->is_active ? $language::get('active') : $language::get('inactive')}}" />
        </div>
    </div>
</div>

<hr />

@include('logged.phone.view')

@if ($address)
    <hr />
    @include('logged.address.view')
@endif

@if ($organization->note)
    <hr />
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>{{$language::get('organization_note')}}</label>
                <textarea class="form-control" disabled="true">{{$organization->note}}</textarea>
            </div>
        </div>
    </div>
@endif