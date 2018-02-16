<?php

namespace App\Repositories;

use App\Models\Transportation;
use App\Models\Transaction;
use App\Models\Material;
use App\Models\Account;
use App\Models\Truck;
use App\Models\Site;
use App\Models\Employee;
use App\Models\EmployeeWage;
use \Carbon\Carbon;
use Auth;

class TransportationRepository
{
    public $rentTypes = [
            1   => 'KM Based Rent',
            2   => 'Weighment Based Rent',
            3   => 'Fixed Rent',
        ];

    /**
     * Return transportations.
     */
    public function getTransportations($params=[], $relationalParams=[], $noOfRecords=null)
    {
        $transportations = Transportation::with(['truck', 'transaction.debitAccount', 'source', 'destination', 'material', 'employee.account'])->where('status', 1);

        foreach ($params as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $transportations = $transportations->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
            }
        }


        foreach ($relationalParams as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $transportations = $transportations->whereHas($param['relation'], function($qry) use($param) {
                    $qry->where($param['paramName'], $param['paramValue']);
                });
            }
        }
        
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $transportations = $transportations->first();
            } else {
                $transportations = $transportations->paginate($noOfRecords);
            }
        } else {
            $transportations= $transportations->get();
        }

        if(empty($transportations) || $transportations->count() < 1) {
            $transportations = [];
        }

        return $transportations;
    }

    /**
     * Return transportations.
     */
    public function getMaterials()
    {
        $materials = Material::where('status', 1)->orderBy('description')->get();

        if(empty($materials) || $materials->count() < 1) {
            $materials = [];
        }

        return $materials;
    }

    /**
     * Return statecodes.
     */
    public function saveTransportation($request)
    {
        $createdUserId  = Auth::user()->id;
        $saveFlag       = 0;

        $truckId                = $request->get('truck_id');
        $transportationDate     = Carbon::createFromFormat('d-m-Y', $request->get('transportation_date'))->format('Y-m-d');
        $sourceId               = $request->get('source_id');
        $destinationId          = $request->get('destination_id');
        $contractorAccountId    = $request->get('contractor_account_id');
        $rentType               = $request->get('rent_type');
        $rentMeasurement        = $request->get('rent_measurement');
        $rentRate               = $request->get('rent_rate');
        $totalRent              = $request->get('total_rent');
        $materialId             = $request->get('material_id');
        $employeeId             = $request->get('employee_id');
        $employeeWage           = $request->get('employee_wage');

        //getting transportation account id
        $transportationRentAccount = Account::where('account_name','Trip Rent')->first();
        if(empty($transportationRentAccount) || empty($transportationRentAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01"
                ];
        }
        $transportationRentAccountId = $transportationRentAccount->id;

        $truck              = Truck::find($truckId)->reg_number;
        $source             = Site::find($sourceId)->name;
        $destination        = Site::find($destinationId)->name;

        $tripDetails        = ( $truck. ", ". $source. " - ". $destination);
        $rentDetails        = (" [". $rentMeasurement. "*". $rentRate. " = ". $totalRent. "]");

        $transaction    = new Transaction;
        $transaction->debit_account_id  = $contractorAccountId; //contractor account
        $transaction->credit_account_id = $transportationRentAccountId; //transportation rent account id
        $transaction->amount            = $totalRent;
        $transaction->transaction_date  = $transportationDate;
        $transaction->particulars       = ("Transportation Rent : ". $tripDetails. $rentDetails);
        $transaction->status            = 1;
        $transaction->created_user_id   = $createdUserId;
        if($transaction->save()) {

            $transportation = new Transportation;
            $transportation->transaction_id = $transaction->id;
            $transportation->date           = $transportationDate;
            $transportation->truck_id       = $truckId;
            $transportation->source_id      = $sourceId;
            $transportation->destination_id = $destinationId;
            $transportation->material_id    = $materialId;
            $transportation->rent_type      = $rentType;
            $transportation->measurement    = $rentMeasurement;
            $transportation->rent_rate      = $rentRate;
            $transportation->total_rent     = $totalRent;
            $transportation->driver_id      = $employeeId;
            $transportation->driver_wage    = $employeeWage;
            $transportation->status         = 1;
            if($transportation->save()) {
                return [
                    'flag'  => true,
                    'id'    => $transportation->id,
                ];
            } else {
                //delete the transaction if transporatation saving failed
                $transaction->forceDelete();

                $saveFlag = '02';
            }
        } else {
            $saveFlag = '03';
        }
        return [
                'flag'      => false,
                'errorCode' => $saveFlag,
            ];
    }

    /**
     * return transportation.
     */
    public function getTransportation($id)
    {
        $transportation = Transportation::with(['source', 'destination', 'truck', 'transaction.debitAccount', 'material', 'employee.account'])->where('status', 1)->where('id', $id)->first();
        if(empty($transportation) || empty($transportation->id)) {
            $transportation = [];
        }

        return $transportation;
    }

    public function deleteTransportation($id, $forceFlag=false)
    {
        $transportation = Transportation::with('transaction')->where('status', 1)->where('id', $id)->first();

        if(!empty($transportation) && !empty($transportation->id)) {
            if($forceFlag) {
                if($transportation->transaction->forceDelete() && $transportation->forceDelete()) {
                    return [
                        'flag'  => true,
                        'force' => false,
                    ];
                } else {
                    $errorCode = '04';
                }
            } else {
                if($transportation->transaction->delete()) {
                    if($transportation->delete()) {
                        return [
                            'flag'  => true,
                            'force' => false,
                        ];
                    } else {
                        $errorCode = '05';
                    }
                } else {
                    $errorCode = '06';
                }
            }
        } else {
            $errorCode = '07';
        }
        return [
            'flag'      => false,
            'errorCode' => $errorCode,
        ];
    }
}
