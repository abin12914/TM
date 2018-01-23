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
}
