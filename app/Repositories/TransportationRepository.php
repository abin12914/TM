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
        $transportations = [];
        
        $transportations = Transportation::where('status', 1);

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
            $transportations = $transportations->paginate($noOfRecords);
        } else {
            $transportations= $transportations->get();
        }

        return $transportations;
    }

    /**
     * Return transportations.
     */
    public function getMaterials()
    {
        $materials = [];
        
        $materials = Material::where('status', 1)->get();

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
        $transportationRentAccount = Account::where('account_name','Transportation Rent')->first();
        if(empty($transportationRentAccount) || empty($transportationRentAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01"
                ];
        }
        $transportationRentAccountId = $transportationRentAccount->id;

        //getting employee wage account id
        $employeeWageAccount = Account::where('account_name','Employee Wage')->first();
        if(empty($employeeWageAccount) || empty($employeeWageAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "02"
                ];
        }
        $employeeWageAccountId = $employeeWageAccount->id;

        $truck              = Truck::find($truckId)->reg_number;
        $source             = Site::find($sourceId)->name;
        $destination        = Site::find($destinationId)->name;
        $employeeAccountId  = Employee::find($employeeId)->account_id;

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

                $wageTransaction    = new Transaction;
                $wageTransaction->debit_account_id  = $employeeAccountId; //employee account
                $wageTransaction->credit_account_id = $employeeWageAccountId; //employee wage account id
                $wageTransaction->amount            = $employeeWage;
                $wageTransaction->transaction_date  = $transportationDate;
                $wageTransaction->particulars       = ("Employee wage [Trip Bata] : ". $tripDetails);
                $wageTransaction->status            = 1;
                $wageTransaction->created_user_id   = $createdUserId;
                if($wageTransaction->save()) {

                    $wage   = new EmployeeWage;
                    $wage->transaction_id   = $wageTransaction->id;
                    $wage->date             = $transportationDate;
                    $wage->wage_type        = 3;
                    $wage->trip_id          = $transportation->id;
                    $wage->wage             = $employeeWage;
                    $wage->status           = 1;
                    if($wage->save()) {

                        return [
                                'flag'  => true,
                                'id'    => $transportation->id,
                            ];
                    } else {
                        //delete the wageTransaction, transportation , transaction if wage saving failed
                        $wageTransaction->delete();
                        $transportation->delete();
                        $transaction->delete();

                        $saveFlag = 3;
                    }
                } else {
                    //delete the transportation , transaction if wageTransaction saving failed
                    $transportation->delete();
                    $transaction->delete();

                    $saveFlag = 4;
                }
            } else {
                //delete the transaction if transporatation saving failed
                $transaction->delete();

                $saveFlag = 5;
            }
        } else {
            $saveFlag = 6;
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
        $transportation = Transportation::where('status', 1)->where('id', $id)->first();

        return $transportation;
    }

    public function deleteTransportation($id)
    {
        $transportation = Transportation::where('status', 1)->where('id', $id)->first();

        if(!empty($transportation) && !empty($transportation->id)) {
            return $transportation->delete();
        }
        return false;
    }
}
