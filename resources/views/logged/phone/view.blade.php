<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>{{$language::get('phone')}} {{$language::get('phone_main')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$phone->number}}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>{{$language::get('phone_type_id')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$phone->type->name}}" />
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>{{$language::get('phone_note')}}</label>
            <input type="text" class="form-control" disabled="true" value="{{$phone->note}}" />
        </div>
    </div>
</div>

@if ($phone2)
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>{{$language::get('phone')}} {{$language::get('phone_secondary')}}</label>
                <input type="text" class="form-control" disabled="true" value="{{$phone2->number}}" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>{{$language::get('phone_type_id')}}</label>
                <input type="text" class="form-control" disabled="true" value="{{$phone2->type->name}}" />
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>{{$language::get('phone_note')}}</label>
                <input type="text" class="form-control" disabled="true" value="{{$phone2->note}}" />
            </div>
        </div>
    </div>
@endif