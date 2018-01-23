<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\Transportation;
use App\Models\Sale;
use App\Models\Account;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class SupplyRepository
{
    public $measureTypes = [
            1   => 'Weighment [Ton]',
            2   => 'Volume [Feet]',
            3   => 'Fixed For TruckType',
        ];

    /**
     * Return supply transportation.
     */
    public function getSupplyTransportations()
    {
        $supplyTransportations = [];
        
        //transportations that has related purchase and sale [supply]
        $supplyTransportations = Transportation::where('status', 1)->has('purchase')->has('sale')->paginate(15);

        return $supplyTransportations;
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
                $transaction->delete();

                $saveFlag = 2;
            }
        } else {
            $saveFlag = 3;
        }
        return [
                'flag'      => false,
                'errorCode' => $saveFlag,
            ];
    }

    /**
     * save sale.
     */
    public function saveSale($request, $transportationId)
    {
        $createdUserId  = Auth::user()->id;
        $saveFlag       = 0;

        $saleDate           = Carbon::createFromFormat('d-m-Y', $request->get('sale_date'))->format('Y-m-d');
        $customerAccountId  = $request->get('customer_account_id');
        $measureType        = $request->get('sale_measure_type');
        $quantity           = $request->get('sale_quantity');
        $rate               = $request->get('sale_rate');
        $discount           = $request->get('sale_discount');
        $totalBill          = $request->get('sale_total_bill');

        //getting transportation account id
        $saleAccount = Account::where('account_name','Sales')->first();
        if(empty($saleAccount) || empty($saleAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01"
                ];
        }
        $saleAccountId = $saleAccount->id;

        $transportation = Transportation::find($transportationId);
        $customer       = Account::find($customerAccountId);
        
        $purchaseDetails = (" to - ". $customer->account_name. " - location - ". $transportation->destination->name. " - ". $transportation->truck->reg_number. " - ". $transportation->material->name. " [". $quantity. " * ". $rate. " - ". $discount. " = ". $totalBill. "]");

        $transaction    = new Transaction;
        $transaction->debit_account_id  = $customerAccountId; //supplier account id
        $transaction->credit_account_id = $saleAccountId; //sale account
        $transaction->amount            = $totalBill;
        $transaction->transaction_date  = $saleDate;
        $transaction->particulars       = ("Sale : ". $purchaseDetails);
        $transaction->status            = 1;
        $transaction->created_user_id   = $createdUserId;
        if($transaction->save()) {

            $sale = new Sale;
            $sale->transaction_id   = $transaction->id;
            $sale->trip_id          = $transportationId;
            $sale->date             = $saleDate;
            $sale->measure_type     = $measureType;
            $sale->quantity         = $quantity;
            $sale->rate             = $rate;
            $sale->discount         = $discount;
            $sale->total_amount     = $totalBill;
            $sale->status         = 1;
            if($sale->save()) {
                return [
                        'flag'  => true,
                        'id'    => $sale->id,
                    ];
            } else {
                //delete the transaction if purchase saving failed
                $transaction->delete();

                $saveFlag = 2;
            }
        } else {
            $saveFlag = 3;
        }
        return [
                'flag'      => false,
                'errorCode' => $saveFlag,
            ];
    }
}
