<div class="form-group">
    <div class="col-sm-6">
        <label for="truck_id" class="control-label"><b style="color: red;">* </b> Truck : </label>
        <select class="form-control select2 {{ !empty($errors->first('truck_id')) ? 'has-error' : '' }}" name="truck_id" id="truck_id" tabindex="1">
            <option value="" {{ empty(old('truck_id')) ? 'selected' : '' }}>Select truck</option>
            @if(!empty($trucks))
                @foreach($trucks as $truck)
                    <option value="{{ $truck->id }}" {{ (old('truck_id') == $truck->id) ? 'selected' : '' }}>
                        {{ $truck->reg_number. " - ". $truck->truckType->name }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('truck_id')))
            <p style="color: red;" >{{$errors->first('truck_id')}}</p>
        @endif
    </div>
    <div class="col-sm-6">
        <label for="transportation_date" class="control-label"><b style="color: red;">* </b> Date : </label>
        <input type="text" class="form-control decimal_number_only datepicker_reg {{ !empty($errors->first('transportation_date')) ? 'has-error' : '' }}" name="transportation_date" id="transportation_date" placeholder="Transportation date" value="{{ old('transportation_date') }}">
        @if(!empty($errors->first('transportation_date')))
            <p style="color: red;" >{{$errors->first('transportation_date')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="source_id" class="control-label"><b style="color: red;">* </b> Source : </label>
        <select class="form-control select2 {{ !empty($errors->first('source_id')) ? 'has-error' : '' }}" name="source_id" id="source_id" tabindex="8">
            <option value="" {{ empty(old('source_id')) ? 'selected' : '' }}>Select source site</option>
            @if(!empty($sites))
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ (old('source_id') == $site->id) ? 'selected' : '' }}>
                        {{ $site->name. ", ". $site->place }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('source_id')))
            <p style="color: red;" >{{$errors->first('source_id')}}</p>
        @endif
    </div>
    <div class="col-sm-6">
        <label for="destination_id" class="control-label"><b style="color: red;">* </b> Destination : </label>
        <select class="form-control select2 {{ !empty($errors->first('destination_id')) ? 'has-error' : '' }}" name="destination_id" id="destination_id" tabindex="8">
            <option value="" {{ empty(old('destination_id')) ? 'selected' : '' }}>Select destination site</option>
            @if(!empty($sites))
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ (old('destination_id') == $site->id) ? 'selected' : '' }}>
                        {{ $site->name. ", ". $site->place }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('destination_id')))
            <p style="color: red;" >{{$errors->first('destination_id')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="contractor_account_id" class="control-label"><b style="color: red;">* </b> Contractor : </label>
        <select class="form-control select2 {{ !empty($errors->first('contractor_account_id')) ? 'has-error' : '' }}" name="contractor_account_id" id="contractor_account_id" tabindex="8">
            <option value="" {{ empty(old('contractor_account_id')) ? 'selected' : '' }}>Select contractor</option>
            @if(!empty($accounts))
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ (old('contractor_account_id') == $account->id) ? 'selected' : '' }}>
                        {{ $account->account_name }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('contractor_account_id')))
            <p style="color: red;" >{{$errors->first('contractor_account_id')}}</p>
        @endif
    </div>
    <div class="col-sm-6">
        <label for="rent_type" class="control-label"><b style="color: red;">* </b> Rent Type : </label>
        <select class="form-control select2 {{ !empty($errors->first('rent_type')) ? 'has-error' : '' }}" name="rent_type" id="rent_type" tabindex="8">
            <option value="" {{ empty(old('rent_type')) ? 'selected' : '' }}>Select rent type</option>
            @if(!empty($rentTypes))
                @foreach($rentTypes as $key => $rentType)
                    <option value="{{ $key }}" {{ (old('rent_type') == $key ) ? 'selected' : '' }}>
                        {{ $rentType }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('rent_type')))
            <p style="color: red;" >{{$errors->first('rent_type')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="rent_measurement" class="control-label"><b style="color: red;">* </b> Measurement/Quantity : </label>
        <input type="text" class="form-control decimal_number_only {{ !empty($errors->first('rent_measurement')) ? 'has-error' : '' }}" name="rent_measurement" id="rent_measurement" placeholder="Measurement" value="{{ old('rent_type') == 3 ? 1 : old('rent_measurement') }}" {{ old('rent_type') == 3 ? "readonly" : "" }}>
        @if(!empty($errors->first('rent_measurement')))
            <p style="color: red;" >{{$errors->first('rent_measurement')}}</p>
        @endif
    </div>
    <div class="col-sm-6">
        <label for="rent_rate" class="control-label"><b style="color: red;">* </b> Rent Rate : </label>
        <input type="text" class="form-control decimal_number_only {{ !empty($errors->first('rent_rate')) ? 'has-error' : '' }}" name="rent_rate" id="rent_rate" placeholder="Rent rate" value="{{ old('rent_rate') }}">
        @if(!empty($errors->first('rent_rate')))
            <p style="color: red;" >{{$errors->first('rent_rate')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="total_rent" class="control-label"><b style="color: red;">* </b> Total Rent : </label>
        <input type="text" class="form-control decimal_number_only {{ !empty($errors->first('total_rent')) ? 'has-error' : '' }}" name="total_rent" id="total_rent" placeholder="Total rent" value="{{ old('total_rent') }}" readonly>
        @if(!empty($errors->first('total_rent')))
            <p style="color: red;" >{{$errors->first('total_rent')}}</p>
        @endif
    </div>
    <div class="col-sm-6">
        <label for="material_id" class="control-label"><b style="color: red;">* </b> Material : </label>
        <select class="form-control select2 {{ !empty($errors->first('material_id')) ? 'has-error' : '' }}" name="material_id" id="material_id" tabindex="8">
            <option value="" {{ empty(old('material_id')) ? 'selected' : '' }}>Select material</option>
            @if(!empty($materials))
                @foreach($materials as $material)
                    <option value="{{ $material->id }}" {{ (old('material_id') == $material->id) ? 'selected' : '' }}>
                        {{ $material->name. " / ". $material->alternate_name }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('material_id')))
            <p style="color: red;" >{{$errors->first('material_id')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="employee_id" class="control-label"><b style="color: red;">* </b> Driver : </label>
        <select class="form-control select2 {{ !empty($errors->first('employee_id')) ? 'has-error' : '' }}" name="employee_id" id="employee_id" tabindex="8">
            <option value="" {{ empty(old('employee_id')) ? 'selected' : '' }}>Select driver</option>
            @if(!empty($employees))
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" data-wage-type={{ $employee->wage_type }} data-wage-amount={{ $employee->wage }} {{ (old('employee_id') == $employee->id) ? 'selected' : '' }}>
                        {{ $employee->account->account_name }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('employee_id')))
            <p style="color: red;" >{{$errors->first('employee_id')}}</p>
        @endif
    </div>
    <div class="col-sm-6">
        <label for="employee_wage" class="control-label"><b style="color: red;">* </b> Driver Bata : </label>
        <input type="text" class="form-control decimal_number_only {{ !empty($errors->first('employee_wage')) ? 'has-error' : '' }}" name="employee_wage" id="employee_wage" placeholder="Driver bata" value="{{ old('employee_wage') }}">
        @if(!empty($errors->first('employee_wage')))
            <p style="color: red;" >{{$errors->first('employee_wage')}}</p>
        @endif
    </div>
</div>