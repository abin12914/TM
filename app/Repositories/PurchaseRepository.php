<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\Transportation;
use App\Models\Account;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class PurchaseRepository
{
    public $measureTypes = [
            1   => 'Weighment [Ton]',
            2   => 'Volume [Feet]',
            3   => 'Fixed For TruckType',
        ];

    /**
     * Return purchases.
     */
    public function getPurchases($params=[], $relationalParams=[], $noOfRecords=null)
    {
        $purchases = Purchase::where('status', 1);

        foreach ($params as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $purchases = $purchases->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
            }
        }


        foreach ($relationalParams as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $purchases = $purchases->whereHas($param['relation'], function($qry) use($param) {
                    $qry->where($param['paramName'], $param['paramValue']);
                });
            }
        }
        
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $purchases = $purchases->first();
            } else {
                $purchases = $purchases->paginate($noOfRecords);
            }

        } else {
            $purchases= $purchases->get();
        }

        if(empty($purchases) || $purchases->count() < 1) {
            $purchases = [];
        }

        return $purchases;
    }


    /**
     * save purchase.
     */
    public function savePurchase($request, $transportationId)
    {
        $createdUserId  = Auth::user()->id;
        $saveFlag       = 0;

        $purchaseDate       = Carbon::createFromFormat('d-m-Y', $request->get('purchase_date'))->format('Y-m-d');
        $supplierAccountId  = $request->get('supplier_account_id');
        $measureType        = $request->get('purchase_measure_type');
        $quantity           = $request->get('purchase_quantity');
        $rate               = $request->get('purchase_rate');
        $discount           = $request->get('purchase_discount');
        $totalBill          = $request->get('purchase_total_bill');

        //getting transportation account id
        $purchaseAccount = Account::where('account_name','Purchases')->first();
        if(empty($purchaseAccount) || empty($purchaseAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01"
                ];
        }
        $purchaseAccountId = $purchaseAccount->id;

        $transportation = Transportation::find($transportationId);
        $supplier       = Account::find($supplierAccountId);
        
        $purchaseDetails = ("from ". $transportation->source->name. " - c/o -". $supplier->account_name. " - ". $transportation->truck->reg_number. " - ". $transportation->material->name. " [". $quantity. " * ". $rate. " - ". $discount. " = ". $totalBill. "]");

        $transaction    = new Transaction;
        $transaction->debit_account_id  = $purchaseAccountId; //purchase account
        $transaction->credit_account_id = $supplierAccountId; //supplier account id
        $transaction->amount            = $totalBill;
        $transaction->transaction_date  = $purchaseDate;
        $transaction->particulars       = ("Purchase : ". $purchaseDetails);
        $transaction->status            = 1;
        $transaction->created_user_id   = $createdUserId;
        if($transaction->save()) {

            $purchase = new Purchase;
            $purchase->transaction_id   = $transaction->id;
            $purchase->trip_id          = $transportationId;
            $purchase->date             = $purchaseDate;
            $purchase->measure_type     = $measureType;
            $purchase->quantity         = $quantity;
            $purchase->rate             = $rate;
            $purchase->discount         = $discount;
            $purchase->total_amount     = $totalBill;
            $purchase->status         = 1;
            if($purchase->save()) {
                return [
                        'flag'  => true,
                        'id'    => $purchase->id,
                    ];
            } else {
                //delete the transaction if purchase saving failed
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
     * Return supply transportation.
     */
    public function getPurchase($id)
    {
        $purchase = Purchase::where('status', 1)->where('id', $id)->first();
        if(empty($purchase) || !empty($purchase->id)) {
            $purchase = [];
        }

        return $purchase;
    }

    public function deletePurchase($id, $forceFlag=false)
    {
        $purchase = Purchase::where('status', 1)->where('id', $id)->first();

        if(!empty($purchase) && !empty($purchase->id)) {
            if($forceFlag) {
                if($purchase->transaction->forceDelete() && $purchase->forceDelete()) {
                    return [
                        'flag'  => true,
                        'force' => true,
                    ];

                } else {
                    $errorCode = '04';
                }
            } else {
                if($purchase->transaction->delete()) {
                    if($purchase->delete()) {
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
