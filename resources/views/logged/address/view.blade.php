<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
        <div class="form-group">
            <label>{{$language::get('address_code')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->code}}" />
        </div>
    </div>

    <div class="col-12 col-md-8 col-lg-6">
        <div class="form-group">
            <label>{{$language::get('address_name')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->name}}" />
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label>{{$language::get('address_number')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->number}}" />
        </div>
    </div>

    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group">
            <label>{{$language::get('address_type_id')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->type->name}}" />
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="form-group">
            <label>{{$language::get('address_neighborhood')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->neighborhood}}" />
        </div>
    </div>

    <div class="col-7 col-md-6 col-lg-3">
        <div class="form-group">
            <label>{{$language::get('address_city')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->city}}" />
        </div>
    </div>

    <div class="col-5 col-md-6 col-lg-2">
        <div class="form-group">
            <label>{{$language::get('address_state')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$address->state}}" />
        </div>
    </div>

    @if ($address->extra)
        <div class="col-12">
            <div class="form-group">
                <label>{{$language::get('address_extra')}}</label>
                <input type="text" class="form-control" disabled="true" value="{{$address->extra}}" />
            </div>
        </div>
    @endif
</div>
