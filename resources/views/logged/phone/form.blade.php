
<fieldset>
    <div class="row">

        <div class="col-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="phone_phone_type_id" class='required'>{{$language::get('phone_type_id')}} {{$language::get('phone_main')}}</label>
                <select id="phone_phone_type_id" class="form-control combo @error('phone_phone_type_id') is-invalid @enderror" name="phone_phone_type_id">
                    @foreach ($phoneType as $type)
                        <option {{ (($phone && $phone->phone_type_id == $type->id) || (old('phone_phone_type_id') == $type->id)) ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                @error('phone_phone_type_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="phone_number" class='required'>{{$language::get('phone_number')}}</label>
                <input type="text" class="form-control telefone @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="{{$language::get('phone_number_placeholder')}}" value="{{$phone ? $phone->number : old('phone_number')}}">
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
            <div class="form-group">
                <label for="phone_note">{{$language::get('phone_note')}} {{$language::get('phone_main')}}</label>
                <input type="text" class="form-control @error('phone_note') is-invalid @enderror" id="phone_note" name="phone_note" placeholder="{{$language::get('phone_note_placeholder')}}" value="{{$phone ? $phone->note : old('phone_note')}}">
                @error('phone_note')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

    </div>

    <hr />

    <div class="row">

        <div class="col-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="phone_phone_type_id_2">{{$language::get('phone_type_id')}} {{$language::get('phone_secondary')}}</label>
                <select id="phone_phone_type_id_2" class="form-control combo @error('phone_phone_type_id_2') is-invalid @enderror" name="phone_phone_type_id_2">
                    @foreach ($phoneType as $type)
                        <option {{ (($phone2 && $phone2->phone_type_id == $type->id) || (old('phone_phone_type_id_2') == $type->id) || (isset($organization) && $type->id == 3)) ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                @error('phone_phone_type_id_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="phone_number_2">{{$language::get('phone_number')}}</label>
                <input type="text" class="form-control telefone @error('phone_number_2') is-invalid @enderror" id="phone_number_2" name="phone_number_2" placeholder="{{$language::get('phone_number_placeholder')}}" value="{{$phone2 ? $phone2->number : old('phone_number_2')}}">
                @error('phone_number_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
            <div class="form-group">
                <label for="phone_note_2">{{$language::get('phone_note')}} {{$language::get('phone_secondary')}}</label>
                <input type="text" class="form-control @error('phone_note_2') is-invalid @enderror" id="phone_note_2" name="phone_note_2" placeholder="{{$language::get('phone_note_placeholder')}}" value="{{$phone2 ? $phone2->note : old('phone_note_2')}}">
                @error('phone_note_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

    </div>

</fieldset>