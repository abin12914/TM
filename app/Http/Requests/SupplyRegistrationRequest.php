<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TransportationRegistrationRequest;
use App\Http\Requests\PurchaseRegistrationRequest;
use App\Http\Requests\SaleRegistrationRequest;

class SupplyRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $transportationRules    = (new TransportationRegistrationRequest())->rules();
        $purchaseRules          = (new PurchaseRegistrationRequest())->rules();
        $saleRules              = (new SaleRegistrationRequest())->rules();

        return array_merge(
            $transportationRules,
            $purchaseRules,
            $saleRules
        );
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->checkTransportationCalculations() || !$this->checkPurchaseCalculations() || !$this->checkSaleCalculations()) {
                $validator->errors()->add('calculations', 'Something went wrong with the calculations!&emsp; Please try again after reloading the page');
            }
        });
    }

    public function checkTransportationCalculations() {
        $quanty     = $this->request->get("rent_measurement");
        $rate       = $this->request->get("rent_rate");
        $rentAmount = $this->request->get("total_rent");

        if(($quanty * $rate) != $rentAmount) {
            return true;
        }
        return false;
    }

    public function checkPurchaseCalculations() {
        $quanty     = $this->request->get("purchase_quantity");
        $rate       = $this->request->get("purchase_rate");
        $bill       = $this->request->get("purchase_bill");
        $discount   = $this->request->get("purchase_discount");
        $totalBill  = $this->request->get("purchase_total_bill");

        if((($quanty * $rate) == $bill) && ($bill - $discount) == $totalBill) {
            return true;
        }
        return false;
    }

    public function checkSaleCalculations() {
        $quanty     = $this->request->get("sale_quantity");
        $rate       = $this->request->get("sale_rate");
        $bill       = $this->request->get("sale_bill");
        $discount   = $this->request->get("sale_discount");
        $totalBill  = $this->request->get("sale_total_bill");

        if((($quanty * $rate) == $bill) && ($bill - $discount) == $totalBill) {
            return true;
        }
        return false;
    }
}
