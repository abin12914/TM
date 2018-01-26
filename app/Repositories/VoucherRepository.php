<?php

namespace App\Repositories;

use App\Models\Voucher;
use App\Models\Account;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class VoucherRepository
{

    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Return trucks.
     */
    public function getVouchers()
    {
        $vouchers = [];
        
        $vouchers = $this->voucher->where('status', 1)->paginate(15);

        return $vouchers;
    }

    /**
     * Save voucher.
     */
    public function saveVoucher($request)
    {
        $transactionType    = $request->get('transaction_type');
        $accountId          = $request->get('voucher_reciept_account_id');
        $date               = Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d');
        $description        = $request->get('description');
        $amount             = $request->get('amount');

        //getting cash account id
        $cashAccount = Account::where('account_name','Cash')->first();
        if(empty($cashAccount) || empty($cashAccount->id)) {
            return [
                    'flag'      => false,
                    'errorCode' => "01",
                ];
        }
        $cashAccountId = $cashAccount->id;

        $account = Account::find($accountId);

        //check transaction type
        if($transactionType == 1) {
            //transaction from giver to cash
            $details = "Cash recieved from : ". $account->account_name;
            $debitAccountId     = $cashAccountId; //cash account
            $creditAccountId    = $accountId; // giver account
        } else {
            //transaction from cash to reciever
            $details = "Cash paid to : ". $account->account_name;
            $debitAccountId     = $accountId;
            $creditAccountId    = $cashAccountId;
        }

        $transaction    = new Transaction;
        $transaction->debit_account_id  = $debitAccountId;
        $transaction->credit_account_id = $creditAccountId;
        $transaction->amount            = $amount;
        $transaction->transaction_date  = $date;
        $transaction->particulars       = $details. " -[". $description. "]";
        $transaction->status            = 1;
        $transaction->created_user_id   = Auth::user()->id;
        if($transaction->save()) {

            $voucher = new Voucher;
            $voucher->transaction_id    = $transaction->id;
            $voucher->date              = $date;
            $voucher->transaction_type  = $transactionType;
            $voucher->amount            = $amount;
            $voucher->status            = 1;
            if($voucher->save()) {
                return [
                        'flag'  => true,
                        'id'    => $voucher->id,
                    ];
            } else {
                //delete the transaction if voucher saving failed
                $transaction->delete();

                $saveFlag = 2;
            }
        } else {
            $saveFlag = 2;
        }
        return [
            'flag'  => false,
            'id'    => $saveFlag,
        ];
    }
}
