<div class="form-group">
    <label class="col-sm-2 control-label">
        <b style="color: red;">* </b> Account : </b>
    </label>
    <div class="col-sm-5 {{ !empty($errors->first('voucher_reciept_account_id')) ? 'has-error' : '' }}">
        <select class="form-control select2" name="voucher_reciept_account_id" id="voucher_reciept_account_id" style="width: 100%;">
            <option value="" {{ empty(old('voucher_reciept_account_id')) ? 'selected' : '' }}>Select account</option>
            @if(!empty($accounts))
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ (old('voucher_reciept_account_id') == $account->id) ? 'selected' : '' }}>{{ $account->account_name }}</option>
                @endforeach
            @endif
        </select>
        @if(!empty($errors->first('voucher_reciept_account_id')))
            <p style="color: red;" >{{$errors->first('voucher_reciept_account_id')}}</p>
        @endif
    </div>
    <div class="col-sm-5">
        <input type="text" class="form-control decimal_number_only datepicker_reg" name="date" id="date" placeholder="Transaction date" value="{{ old('date') }}">
        @if(!empty($errors->first('date')))
            <p style="color: red;" >{{$errors->first('date')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description : </label>
    <div class="col-sm-10 {{ !empty($errors->first('description')) ? 'has-error' : '' }}">
        @if(!empty(old('description')))
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Truck Description" style="resize: none;" tabindex="5">{{ old('description') }}</textarea>
        @else
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Truck Description" style="resize: none;" tabindex="5"></textarea>
        @endif
        @if(!empty($errors->first('description')))
            <p style="color: red;" >{{$errors->first('description')}}</p>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"><b style="color: red;">* </b> Amount : </label>
    <div class="col-sm-10 {{ !empty($errors->first('amount')) ? 'has-error' : '' }}">
        <input type="text" class="form-control decimal_number_only" name="amount" id="amount" placeholder="Transaction amount" value="{{ old('amount') }}" maxlength="9">
        @if(!empty($errors->first('amount')))
            <p style="color: red;" >{{$errors->first('amount')}}</p>
        @endif
    </div>
</div>