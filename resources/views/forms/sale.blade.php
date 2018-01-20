<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('customer_account_id')) ? 'has-error' : '' }}">
        <label for="customer_account_id" class="control-label"><b style="color: red;">* </b> Customer : </label>
        <select class="form-control select2" name="customer_account_id" id="customer_account_id" style="width: 100%;">
            <option value="" {{ empty(old('customer_account_id')) ? 'selected' : '' }}>Select customer</option>
            @if(!empty($accounts))
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ (old('customer_account_id') == $account->id) ? 'selected' : '' }}>
                        {{ $account->account_name }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('customer_account_id')))
            <p style="color: red;" >{{$errors->first('customer_account_id')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('sale_date')) ? 'has-error' : '' }}">
        <label for="sale_date" class="control-label"><b style="color: red;">* </b> Sale Date : </label>
        <input type="text" class="form-control decimal_number_only datepicker_reg" name="sale_date" id="sale_date" placeholder="Sale date" value="{{ old('sale_date') }}">
        @if(!empty($errors->first('sale_date')))
            <p style="color: red;" >{{$errors->first('sale_date')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('sale_measure_type')) ? 'has-error' : '' }}">
        <label for="sale_measure_type" class="control-label"><b style="color: red;">* </b> Measure Type : </label>
        <select class="form-control select2" name="sale_measure_type" id="sale_measure_type" style="width: 100%;">
            <option value="" {{ empty(old('sale_measure_type')) ? 'selected' : '' }}>Select measure type</option>
            @if(!empty($measureTypes))
                @foreach($measureTypes as $key => $measureType)
                    <option value="{{ $key }}" {{ (old('sale_measure_type') == $key ) ? 'selected' : '' }}>
                        {{ $measureType }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('sale_measure_type')))
            <p style="color: red;" >{{$errors->first('sale_measure_type')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('sale_quantity')) ? 'has-error' : '' }}">
        <label for="sale_quantity" class="control-label"><b style="color: red;">* </b> Measurement/Quantity : </label>
        <input type="text" class="form-control decimal_number_only" name="sale_quantity" id="sale_quantity" placeholder="Measurement/Quantity" value="{{ old('sale_quantity') }}">
        @if(!empty($errors->first('sale_quantity')))
            <p style="color: red;" >{{$errors->first('sale_quantity')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('sale_rate')) ? 'has-error' : '' }}">
        <label for="sale_rate" class="control-label"><b style="color: red;">* </b> Unit Rate : </label>
        <input type="text" class="form-control decimal_number_only" name="sale_rate" id="sale_rate" placeholder="Sale rate" value="{{ old('sale_rate') }}">
        @if(!empty($errors->first('sale_rate')))
            <p style="color: red;" >{{$errors->first('sale_rate')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('sale_bill')) ? 'has-error' : '' }}">
        <label for="sale_bill" class="control-label"><b style="color: red;">* </b> Bill Amount : </label>
        <input type="text" class="form-control decimal_number_only" name="sale_bill" id="sale_bill" placeholder="Sale bill" value="{{ old('sale_bill') }}" readonly>
        @if(!empty($errors->first('sale_bill')))
            <p style="color: red;" >{{$errors->first('sale_bill')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('sale_discount')) ? 'has-error' : '' }}">
        <label for="sale_discount" class="control-label"><b style="color: red;">* </b> Discount : </label>
        <input type="text" class="form-control decimal_number_only" name="sale_discount" id="sale_discount" placeholder="Sale discount" value="{{ old('sale_discount') }}">
        @if(!empty($errors->first('sale_discount')))
            <p style="color: red;" >{{$errors->first('sale_discount')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('sale__total_bill')) ? 'has-error' : '' }}">
        <label for="sale__total_bill" class="control-label"><b style="color: red;">* </b> Total Bill : </label>
        <input type="text" class="form-control decimal_number_only" name="sale__total_bill" id="sale__total_bill" placeholder="Total sale bill" value="{{ old('sale__total_bill') }}" readonly>
        @if(!empty($errors->first('sale__total_bill')))
            <p style="color: red;" >{{$errors->first('sale__total_bill')}}</p>
        @endif
    </div>
</div>