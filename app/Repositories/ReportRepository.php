<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\Account;
use \Carbon\Carbon;
use Auth;

class ReportRepository
{
    public $transactionRelations = [
            1   => 'employeeWage',
            2   => 'expense',
            3   => 'purchase',
            4   => 'sale',
            5   => 'transportation',
            6   => 'voucher',
        ];

    /**
     * Return view for account statement
     */
    public function getAccountStatement($params=[], $noOfRecords=null)
    {
        $overviewDebit  = 0;
        $overviewCredit = 0;
        $obDebit        = 0;
        $obCredit       = 0;
        $subtotalDebit  = 0;
        $subtotalCredit = 0;
        $totalDebit     = 0;
        $totalCredit    = 0;

        if(empty($params['account_id'])) {
            $account = Account::where('account_name', "Cash")->first();
            if(!empty($account) && !empty($account->id)) {
                $params['account_id'] = $account->id;
            } else {
                return [
                    'flag'          => false,
                    'error_code'    => '01',
                ];
            }
        }

        $overviewDebit     = Transaction::where('debit_account_id', $params['account_id'])->sum('amount');
        $overviewCredit    = Transaction::where('credit_account_id', $params['account_id'])->sum('amount');

        $query = Transaction::where('status', 1);

        if(!empty($params['relation_type'])) {
            $query = $query->has($this->transactionRelations[$params['relation_type']]);
        }

        if(empty($params['transaction_type'])) {
            $query = $query->where(function ($qry) use($params) {
                $qry->where('debit_account_id', $params['account_id'])->orWhere('credit_account_id', $params['account_id']);
            });
        } elseif ($params['transaction_type'] == 1) {
            $query = $query->where(function ($qry) use($params) {
                $qry->where('debit_account_id', $params['account_id']);
            });
        } else {
            $query = $query->where(function ($qry) use($params) {
                $qry->where('credit_account_id', $params['account_id']);
            });
        }

        if(!empty($params['from_date'])) {
            $searchFromDate = Carbon::createFromFormat('d-m-Y', $params['from_date'])->format('Y-m-d');
            $query          = $query->where('transaction_date', '>=', $searchFromDate);

            $obDebit    = Transaction::where('debit_account_id', $params['account_id'])->where('transaction_date', '<', $searchFromDate)->sum('amount');
            $obCredit   = Transaction::where('credit_account_id', $params['account_id'])->where('transaction_date', '<', $searchFromDate)->sum('amount');
        }

        if(!empty($params['to_date'])) {
            $searchToDate = Carbon::createFromFormat('d-m-Y', $params['to_date'])->format('Y-m-d');
            $query = $query->where('transaction_date', '<=', $searchToDate);
        }

        $subtotalDebitQuery = clone $query;
        $subtotalDebit      = $subtotalDebitQuery->where('debit_account_id', $params['account_id'])->sum('amount');

        $subtotalCreditQuery    = clone $query;
        $subtotalCredit         = $subtotalCreditQuery->where('credit_account_id', $params['account_id'])->sum('amount');

        $totalDebit     = $obDebit + $subtotalDebit;
        $totalCredit    = $obCredit + $subtotalCredit;

        $transactions = $query->orderBy('transaction_date','asc')->orderBy('id','asc');

        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $transactions   = $transactions->first();
            } else {
                $transactions   = $transactions->paginate($noOfRecords);
            }
        } else {
            $transactions   = $transactions->get();
        }

        if(empty($transactions) || $transactions->count() < 1) {
            $transactions = [];
        }

        return [
                'flag'              => true,
                'account_id'        => $params['account_id'],//return account id as if the account id is empty cash account is selected.
                'transactions'      => $transactions,
                'overviewDebit'     => $overviewDebit,
                'overviewCredit'    => $overviewCredit,
                'obDebit'           => $obDebit,
                'obCredit'          => $obCredit,
                'subtotalDebit'     => $subtotalDebit,
                'subtotalCredit'    => $subtotalCredit,
                'totalCredit'       => $totalCredit,
                'totalDebit'        => $totalDebit,
            ];
    }
}
