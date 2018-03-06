<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Truck;
use App\Models\Site;
use App\Models\Account;
use App\Repositories\TransportationRepository;

class PurchaseAjaxRequests extends FormRequest
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
        $transportationRepo  = new TransportationRepository();
        $customRules = [];

        if ($this->request->get('type') == 'purchaseDetailsByCombo') {
            $customRules = [
                'truck_id'              =>  [
                                                'required',
                                                Rule::in(Truck::pluck('id')->toArray()),
                                            ],
                'source_id'             =>  [
                                                'required',
                                                Rule::in(Site::pluck('id')->toArray()),
                                            ],
                'material_id'           =>  [
                                                'required',
                                                Rule::in($transportationRepo->getMaterials()->pluck('id')->toArray()),
                                            ],
                'supplier_account_id'   =>  [
                                                'required',
                                                Rule::in(Account::pluck('id')->toArray()),
                                            ],
            ];
        }
        return $customRules;
    }
}
