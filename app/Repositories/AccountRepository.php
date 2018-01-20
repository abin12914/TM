<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\AccountDetail;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class AccountRepository
{

    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Return accounts.
     */
    public function getAccounts($slug = null, $value = null, $noOfRecord = null)
    {
        $accounts = [];
        
        //type 3 accounts are personal accounts
        $accounts = $this->account->where('status', 1)->where('type', 3);

        if(!empty($slug) && !empty($value)) {
            $accounts = $accounts->where($slug,$value);
        }
        if(!empty($noOfRecord)) {
            $accounts = $accounts->paginate($noOfRecord);
        } else {
            $accounts = $accounts->get();
        }

        return $accounts;
    }

    /**
     * Action for saving accounts.
     */
    public function saveAccount($request)
    {
        $saveFlag = 0;
        
        $accountName        = $request->get('account_name');
        $description        = $request->get('description');
        $financialStatus    = $request->get('financial_status');
        $openingBalance     = $request->get('opening_balance');
        $name               = $request->get('name');
        $phone              = $request->get('phone');
        $address            = $request->get('address');
        $relation           = $request->get('relation_type');

        $openingBalanceAccount = $this->account->where('account_name','Account Opening Balance')->first();
        if(!empty($openingBalanceAccount) && !empty($openingBalanceAccount->id)) {
            $openingBalanceAccountId = $openingBalanceAccount->id;
        } else {
            return [
                'flag'      => false,
                'errorCode' => "01"
            ];
        }

        $account = new Account;
        $account->account_name      = $accountName;
        $account->description       = $description;
        $account->type              = 3;
        $account->relation          = $relation;
        $account->financial_status  = $financialStatus;
        $account->opening_balance   = $openingBalance;
        $account->status            = 1;
        if($account->save()) {
            $accountDetails = new AccountDetail;
            $accountDetails->account_id = $account->id;
            $accountDetails->name       = $name;
            $accountDetails->phone      = $phone;
            $accountDetails->address    = $address;
            $accountDetails->status     = 1;
            if($accountDetails->save()) {
                if($financialStatus == 1) {//incoming [account holder gives cash to company] [Creditor]
                    $debitAccountId     = $openingBalanceAccountId;//flow into the opening balance account
                    $creditAccountId    = $account->id;//flow out from new account
                    $particulars        = "Opening balance of ". $name . " - Debit [Creditor]";
                } else if($financialStatus == 2){//outgoing [company gives cash to account holder] [Debitor]
                    $debitAccountId     = $account->id;//flow into new account
                    $creditAccountId    = $openingBalanceAccountId;//flow out from the opening balance account
                    $particulars        = "Opening balance of ". $name . " - Credit [Debitor]";
                } else {
                    $debitAccountId     = $openingBalanceAccountId;
                    $creditAccountId    = $account->id;
                    $particulars        = "Opening balance of ". $name . " - None";
                    $openingBalance     = 0;
                }

                $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                
                $transaction = new Transaction;
                $transaction->debit_account_id  = $debitAccountId;
                $transaction->credit_account_id = $creditAccountId;
                $transaction->amount            = !empty($openingBalance) ? $openingBalance : '0';
                $transaction->transaction_date  = $dateTime;
                $transaction->particulars       = $particulars;
                $transaction->status            = 1;
                $transaction->created_user_id   = Auth::user()->id;
                if($transaction->save()) {
                    $saveFlag = 1;
                } else {
                    //delete the account, account detail if opening balance transaction saving failed
                    $account->delete();
                    $accountDetails->delete();

                    $saveFlag = 2;
                }
            } else {
                //delete the account if account details saving failed
                $account->delete();

                $saveFlag = 3;
            }
        } else {
            $saveFlag = 4;
        }

        if($saveFlag == 1) {
            return [
                'flag'  => true,
                'id'    => $account->id,
            ];
        } else {
            return [
                'flag'      => false,
                'errorCode' => $saveFlag,
            ];
        }
    }
}
