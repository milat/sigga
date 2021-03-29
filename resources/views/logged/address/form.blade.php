
<fieldset>

    <div class="row">
        <div class="col-12 col-md-2">
            <div class="form-group">
                <label for="address_postal_code">{{$language::get('address_postal_code')}}</label>
                <input type="text" class="form-control cep @error('address_postal_code') is-invalid @enderror" id="address_postal_code" name="address_postal_code" placeholder="{{$language::get('address_postal_code_placeholder')}}" value="{{$address ? $address->postal_code : old('address_postal_code')}}">
                @error('address_postal_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="address_address" class="{{ $isAddressRequired ? 'required' : '' }}">{{$language::get('address_address')}}</label>
                <input type="text" class="form-control @error('address_address') is-invalid @enderror" id="address_address" name="address_address" placeholder="{{$language::get('address_address_placeholder')}}" value="{{$address ? $address->address : old('address_address')}}">
                @error('address_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label for="address_number" class="{{ $isAddressRequired ? 'required' : '' }}">{{$language::get('address_number')}}</label>
                <input type="text" class="form-control @error('address_number') is-invalid @enderror" id="address_number" name="address_number" placeholder="{{$language::get('address_number_placeholder')}}" value="{{$address ? $address->number : old('address_number')}}">
                @error('address_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label for="address_address_type_id" class="{{ $isAddressRequired ? 'required' : '' }}">{{$language::get('address_type_id')}}</label>
                <select id="address_address_type_id" class="form-control combo @error('address_address_type_id') is-invalid @enderror" name="address_address_type_id">
                    @foreach ($addressType as $type)
                        <option {{ (($address && $address->address_type_id == $type->id) || (old('address_address_type_id') == $type->id) || (isset($organization) && $type->id == 2)) ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                @error('address_address_type_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label for="address_neighborhood" class="{{ $isAddressRequired ? 'required' : '' }}">{{$language::get('address_neighborhood')}}</label>
                <input type="text" class="form-control @error('address_neighborhood') is-invalid @enderror" id="address_neighborhood" name="address_neighborhood" placeholder="{{$language::get('address_neighborhood_placeholder')}}" value="{{$address ? $address->neighborhood : old('address_neighborhood')}}">
                @error('address_neighborhood')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label for="address_city" class="{{ $isAddressRequired ? 'required' : '' }}">{{$language::get('address_city')}}</label>
                <input type="text" class="form-control @error('address_city') is-invalid @enderror" id="address_city" name="address_city" placeholder="{{$language::get('address_city_placeholder')}}" value="{{$address ? $address->city : old('address_city')}}">
                @error('address_city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-1">
            <div class="form-group">
                <label for="address_state" class="{{ $isAddressRequired ? 'required' : '' }}">{{$language::get('address_state')}}</label>
                <input type="text" class="form-control @error('address_state') is-invalid @enderror" id="address_state" name="address_state" placeholder="{{$language::get('address_state_placeholder')}}" value="{{$address ? $address->state : old('address_state')}}">
                @error('address_state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label for="address_extra">{{$language::get('address_extra')}}</label>
                <input type="text" class="form-control @error('address_extra') is-invalid @enderror" id="address_extra" name="address_extra" placeholder="{{$language::get('address_extra_placeholder')}}" value="{{$address ? $address->extra : old('address_extra')}}">
                @error('address_extra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

    </div>

</fieldset>