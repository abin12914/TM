<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Truck;
use App\Models\Site;
use App\Models\Employee;
use App\Models\EmployeeWage;
use \Carbon\Carbon;
use Auth;

class EmployeeWageRepository
{
    /**
     * Return employeeWages.
     */
    public function getEmployeeWages($params=[], $relationalParams=[], $noOfRecords=null)
    {
        $employeeWages = EmployeeWage::where('status', 1);

        foreach ($params as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $employeeWages = $employeeWages->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
            }
        }


        foreach ($relationalParams as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $employeeWages = $employeeWages->whereHas($param['relation'], function($qry) use($param) {
                    $qry->where($param['paramName'], $param['paramValue']);
                });
            }
        }
        
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $employeeWages = $employeeWages->first();
            } else {
                $employeeWages = $employeeWages->paginate($noOfRecords);
            }
        } else {
            $employeeWages= $employeeWages->get();
        }
        if(empty($employeeWages) || $employeeWages->count() < 1) {
            $employeeWages = [];
        }

        return $employeeWages;
    }

    /**
     * Action for employeeWage save.
     */
    public function saveEmployeeWage($request, $transportationId)
    {
        $transportationDate     = Carbon::createFromFormat('d-m-Y', $request->get('transportation_date'))->format('Y-m-d');
        $truckId                = $request->get('truck_id');
        $sourceId               = $request->get('source_id');
        $destinationId          = $request->get('destination_id');
        $employeeId             = $request->get('employee_id');
        $employeeWage           = $request->get('employee_wage');

        //getting employee wage account id
        $employeeWageAccount = Account::where('account_name','Employee Wage')->first();
        if(empty($employeeWageAccount) || empty($employeeWageAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01"
                ];
        }
        $employeeWageAccountId = $employeeWageAccount->id;

        $truck              = Truck::find($truckId)->reg_number;
        $source             = Site::find($sourceId)->name;
        $destination        = Site::find($destinationId)->name;
        $employeeAccountId  = Employee::find($employeeId)->account_id;

        $tripDetails        = ( $truck. ", ". $source. " - ". $destination);

        $transaction    = new Transaction;
        $transaction->debit_account_id  = $employeeWageAccountId; //employee wage account id
        $transaction->credit_account_id = $employeeAccountId; //employee account
        $transaction->amount            = $employeeWage;
        $transaction->transaction_date  = $transportationDate;
        $transaction->particulars       = ("Employee wage [Trip Bata] : ". $tripDetails);
        $transaction->status            = 1;
        $transaction->created_user_id   = Auth::user()->id;
        if($transaction->save()) {

            $wage   = new EmployeeWage;
            $wage->transaction_id   = $transaction->id;
            $wage->date             = $transportationDate;
            $wage->wage_type        = 3;
            $wage->trip_id          = $transportationId;
            $wage->wage             = $employeeWage;
            $wage->status           = 1;
            if($wage->save()) {

                return [
                        'flag'  => true,
                        'id'    => $wage->id,
                    ];
            } else {
                //delete the transaction if wage saving failed
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
     * return expense.
     */
    public function getEmployeeWage($id)
    {
        $employeeWage = EmployeeWage::where('status', 1)->where('id', $id)->first();
        if(empty($employeeWage) || empty($employeeWage->id)) {
            $employeeWage = [];
        }

        return $employeeWage;
    }

    public function deleteEmployeeWage($id, $forceFlag=false)
    {
        $errorCode = 'Unknown';
        $employeeWage = EmployeeWage::where('status', 1)->where('id', $id)->first();

        if(!empty($employeeWage) && !empty($employeeWage->id)) {
            if($forceFlag) {
                if($employeeWage->transaction->forceDelete() && $employeeWage->forceDelete()) {
                    return [
                        'flag'  => true,
                        'force' => true,
                    ];
                } else {
                    $errorCode = '05';
                }
            } else {
                if($employeeWage->transaction->delete()) {
                    if($employeeWage->delete()) {
                        return [
                            'flag'  => true,
                            'force' => false,
                        ];
                    } else {
                        $errorCode = '06';
                    }
                } else {
                    $errorCode = '07';
                }
            }
        } else {
            $errorCode = '08';
        }
        return [
            'flag'          => false,
            'error_code'    => $errorCode,
        ];
    }
}
