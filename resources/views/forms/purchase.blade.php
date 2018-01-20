<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('supplier_account_id')) ? 'has-error' : '' }}">
        <label for="supplier_account_id" class="control-label"><b style="color: red;">* </b> Supplier : </label>
        <select class="form-control select2" name="supplier_account_id" id="supplier_account_id" style="width: 100%;">
            <option value="" {{ empty(old('supplier_account_id')) ? 'selected' : '' }}>Select supplier</option>
            @if(!empty($accounts))
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ (old('supplier_account_id') == $account->id) ? 'selected' : '' }}>
                        {{ $account->account_name }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('supplier_account_id')))
            <p style="color: red;" >{{$errors->first('supplier_account_id')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('purchase_date')) ? 'has-error' : '' }}">
        <label for="purchase_date" class="control-label"><b style="color: red;">* </b> Purchase Date : </label>
        <input type="text" class="form-control decimal_number_only datepicker_reg" name="purchase_date" id="purchase_date" placeholder="Purchase date" value="{{ old('purchase_date') }}">
        @if(!empty($errors->first('purchase_date')))
            <p style="color: red;" >{{$errors->first('purchase_date')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('purchase_measure_type')) ? 'has-error' : '' }}">
        <label for="purchase_measure_type" class="control-label"><b style="color: red;">* </b> Measure Type : </label>
        <select class="form-control select2" name="purchase_measure_type" id="purchase_measure_type" style="width: 100%;">
            <option value="" {{ empty(old('purchase_measure_type')) ? 'selected' : '' }}>Select measure type</option>
            @if(!empty($measureTypes))
                @foreach($measureTypes as $key => $measureType)
                    <option value="{{ $key }}" {{ (old('purchase_measure_type') == $key ) ? 'selected' : '' }}>
                        {{ $measureType }}
                    </option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('purchase_measure_type')))
            <p style="color: red;" >{{$errors->first('purchase_measure_type')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('purchase_quantity')) ? 'has-error' : '' }}">
        <label for="purchase_quantity" class="control-label"><b style="color: red;">* </b> Measurement/Quantity : </label>
        <input type="text" class="form-control decimal_number_only" name="purchase_quantity" id="purchase_quantity" placeholder="Measurement/Quantity" value="{{ old('purchase_quantity') }}">
        @if(!empty($errors->first('purchase_quantity')))
            <p style="color: red;" >{{$errors->first('purchase_quantity')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('purchase_rate')) ? 'has-error' : '' }}">
        <label for="purchase_rate" class="control-label"><b style="color: red;">* </b> Unit Rate : </label>
        <input type="text" class="form-control decimal_number_only" name="purchase_rate" id="purchase_rate" placeholder="Purchase rate" value="{{ old('purchase_rate') }}">
        @if(!empty($errors->first('purchase_rate')))
            <p style="color: red;" >{{$errors->first('purchase_rate')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('purchase_bill')) ? 'has-error' : '' }}">
        <label for="purchase_bill" class="control-label"><b style="color: red;">* </b> Bill Amount : </label>
        <input type="text" class="form-control decimal_number_only" name="purchase_bill" id="purchase_bill" placeholder="Purchase bill" value="{{ old('purchase_bill') }}" readonly>
        @if(!empty($errors->first('purchase_bill')))
            <p style="color: red;" >{{$errors->first('purchase_bill')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6 {{ !empty($errors->first('purchase_discount')) ? 'has-error' : '' }}">
        <label for="purchase_discount" class="control-label"><b style="color: red;">* </b> Discount : </label>
        <input type="text" class="form-control decimal_number_only" name="purchase_discount" id="purchase_discount" placeholder="Purchase discount" value="{{ old('purchase_discount') }}">
        @if(!empty($errors->first('purchase_discount')))
            <p style="color: red;" >{{$errors->first('purchase_discount')}}</p>
        @endif
    </div>
    <div class="col-sm-6 {{ !empty($errors->first('purchase__total_bill')) ? 'has-error' : '' }}">
        <label for="purchase__total_bill" class="control-label"><b style="color: red;">* </b> Total Bill : </label>
        <input type="text" class="form-control decimal_number_only" name="purchase__total_bill" id="purchase__total_bill" placeholder="Total purchase bill" value="{{ old('purchase__total_bill') }}" readonly>
        @if(!empty($errors->first('purchase__total_bill')))
            <p style="color: red;" >{{$errors->first('purchase__total_bill')}}</p>
        @endif
    </div>
</div>