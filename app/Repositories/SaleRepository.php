<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\Transportation;
use App\Models\Sale;
use App\Models\Account;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class SaleRepository
{
    /**
     * Return sales.
     */
    public function getSales($params=[], $relationalParams=[], $noOfRecords=null)
    {
        //transportations that has related purchase and sale [supply]
        $sales = Sale::where('status', 1);

        foreach ($params as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $sales = $sales->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
            }
        }


        foreach ($relationalParams as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $sales = $sales->whereHas($param['relation'], function($qry) use($param) {
                    $qry->where($param['paramName'], $param['paramValue']);
                });
            }
        }
        
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $sales = $sales->first();
            } else {
                $sales = $sales->paginate($noOfRecords);
            }

        } else {
            $sales= $sales->get();
        }

        if(empty($sales) || $sales->count() < 1) {
            $sales = [];
        }

        return $sales;
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
    public function getSale($params=[], $relationalParams=[], $order=[])
    {
        $sale = Sale::with(['transaction', 'transportation'])->where('status', 1);

        //custom parameters
        foreach ($params as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $sale = $sale->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
            }
        }

        foreach ($relationalParams as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $sale = $sale->whereHas($param['relation'], function($qry) use($param) {
                    $qry->where($param['paramName'], $param['paramValue']);
                });
            }
        }

        //custom ordering if any
        if(!empty($order)) {
            $sale = $sale->orderBy($order['order_key'], $order['order_type']);
        }

        //secondary ordering apart from custom ordering for more accuracy
        //selecting first element after the ordering
        $sale = $sale->orderBy('id', 'desc')->first();
        
        if(empty($sale) || !empty($sale->id)) {
            $sale = [];
        }

        return $sale;
    }

    public function deleteSale($id, $forceFlag=false)
    {
        $sale = Sale::where('status', 1)->where('id', $id)->first();

        if(!empty($sale) && !empty($sale->id)) {
            if($forceFlag) {
                if($sale->transaction->forceDelete() && $sale->forceDelete()) {
                    return [
                        'flag'  => true,
                        'force' => true,
                    ];

                } else {
                    $errorCode = '04';
                }
            } else {
                if($sale->transaction->delete()) {
                    if($sale->delete()) {
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
