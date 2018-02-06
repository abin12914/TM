<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReportRepository;
use App\Repositories\AccountRepository;
use App\Http\Requests\AccountStatementFilterRequest;

class ReportController extends Controller
{
    protected $reportRepo, $accountRepo;
    public $errorHead = 7, $noOfRecordsPerPage = 15;

    public function __construct(ReportRepository $reportRepo, AccountRepository $accountRepo)
    {
        $this->reportRepo   = $reportRepo;
        $this->accountRepo  = $accountRepo;
    }

    /**
     * Display a listing of the account transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function accountStatement(AccountStatementFilterRequest $request)
    {
        $noOfRecords    = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

        $params = [
                'from_date'         => $request->get('from_date'),
                'to_date'           => $request->get('to_date'),
                'account_id'        => $request->get('account_id'),
                'relation_type'     => $request->get('relation_type'),
                'transaction_type'  => $request->get('transaction_type'),
            ];

        $result = $this->reportRepo->getAccountStatement($params, $noOfRecords);

        $accounts       = $this->accountRepo->getAccounts();
        $cashAccount    = $this->accountRepo->getAccounts(['account_name' => 'Cash'], 1, false);//retrieving cash account
        if(!empty($cashAccount) && !empty($cashAccount->id)) {
            $accounts->push($cashAccount);//pushing cash account to account list
        }
        
        if($result['flag']) {
            $params['account_id'] = $result['account_id'];

            return view('reports.account-statement', [
                    'transactions'      => $result['transactions'],
                    'overviewDebit'     => $result['overviewDebit'],
                    'overviewCredit'    => $result['overviewCredit'],
                    'obDebit'           => $result['obDebit'],
                    'obCredit'          => $result['obCredit'],
                    'subtotalDebit'     => $result['subtotalDebit'],
                    'subtotalCredit'    => $result['subtotalCredit'],
                    'totalDebit'        => $result['totalDebit'],
                    'totalCredit'       => $result['totalCredit'],
                    'relations'         => $this->reportRepo->transactionRelations,
                    'accounts'          => $accounts,
                    'params'            => $params,
                    'noOfRecords'       => $noOfRecords,
                ]);
        }

        return view('reports.account-statement', [
                'transactions'      => [],
                'overviewDebit'     => 0,
                'overviewCredit'    => 0,
                'obDebit'           => 0,
                'obCredit'          => 0,
                'subtotalDebit'     => 0,
                'subtotalCredit'    => 0,
                'totalDebit'        => 0,
                'totalCredit'       => 0,
                'relations'         => $this->reportRepo->transactionRelations,
                'accounts'          => $accounts,
                'params'            => $params,
                'params'            => $params,
                'noOfRecords'       => $noOfRecords,
            ]);
    }
}
