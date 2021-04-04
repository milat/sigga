<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>{{$language::get('user_email')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$user->email}}" />
        </div>
    </div>
</div>

@can('user')
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>{{$language::get('user_role_id')}}</label>
                <input type="text" class="form-control" disabled="true" value="{{$user->role->name}}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>{{$language::get('user_is_active')}}</label>
                <input type="text" class="form-control" disabled="true" value="{{$user->is_active ? $language::get('active') : $language::get('inactive')}}" />
            </div>
        </div>
        @if ($user->identity_document)
            <div class="col-12">
                <div class="form-group">
                    <label>{{$language::get('user_identity_document')}}</label>
                    <input type="text" class="form-control" disabled="true" value="{{$user->identity_document}}" />
                </div>
            </div>
        @endif
    </div>
@endcan