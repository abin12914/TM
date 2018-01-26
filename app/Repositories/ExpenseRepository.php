<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Models\Service;
use App\Models\Account;
use App\Models\Truck;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class ExpenseRepository
{

    protected $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Return statecodes.
     */
    public function getServices()
    {
        $stateCodes = [];

        $stateCodes = Service::orderBy('name')->get();

        return $stateCodes;
    }

    /**
     * Return expenses.
     */
    public function getExpences()
    {
        $expenses = [];
        
        $expenses = Expense::where('status', 1)->paginate(15);

        return $expenses;
    }

    /**
     * Action for expense save.
     */
    public function saveExpense($request)
    {
        $transactionType    = $request->get('transaction_type');
        $supplierAccountId  = $request->get('supplier_account_id');
        $truckId            = $request->get('truck_id');
        $date               = Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d');
        $serviceId          = $request->get('service_id');
        $description        = $request->get('description');
        $billAmount         = $request->get('bill_amount');

        //getting service and expense account id
        $expenseAccount = Account::where('account_name','Service And Expenses')->first();
        if(empty($expenseAccount) || empty($expenseAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01"
                ];
        }
        $expenseAccountId = $expenseAccount->id;

        if($transactionType == 1) {
            $supplierAccount = Account::find($supplierAccountId);
        } else {
            $supplierAccount = Account::where('account_name', 'Cash')->first();

            if(empty($supplierAccount) || empty($supplierAccount->id)) {
                return [
                        'flag'      => false,
                        'errorCode' => "02"
                    ];
            }
        }
        $truck = Truck::find($truckId);
        $service = Service::find($serviceId);

        $transaction    = new Transaction;
        $transaction->debit_account_id  = $expenseAccountId; //service and expense account
        $transaction->credit_account_id = $supplierAccount->id; //supplier account id
        $transaction->amount            = $billAmount;
        $transaction->transaction_date  = $date;
        $transaction->particulars       = ("Service Expense : ". $truck->reg_number. " - ". $service->name. " -[". $description. "]");
        $transaction->status            = 1;
        $transaction->created_user_id   = Auth::user()->id;
        if($transaction->save()) {

            $expense = new Expense;
            $expense->transaction_id = $transaction->id;
            $expense->date           = $date;
            $expense->truck_id       = $truckId;
            $expense->service_id     = $serviceId;
            $expense->bill_amount    = $billAmount;
            $expense->status         = 1;
            if($expense->save()) {
                return [
                        'flag'  => true,
                        'id'    => $expense->id,
                    ];
            } else {
                //delete the transaction if expense saving failed
                $transaction->delete();

                $saveFlag = 3;
            }
        } else {
            $saveFlag = 4;
        }
        return [
            'flag'  => false,
            'id'    => $saveFlag,
        ];
    }
}
