<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VoucherRepository;
use App\Repositories\AccountRepository;
use App\Http\Requests\VoucherRegistrationRequest;
use App\Http\Requests\VoucherFilterRequest;
use \Carbon\Carbon;

class VoucherController extends Controller
{
    protected $voucherRepo, $accountRepo;
    public $errorHead = 7, $noOfRecordsPerPage = 15;

     public function __construct(VoucherRepository $voucherRepo, AccountRepository $accountRepo)
    {
        $this->voucherRepo  = $voucherRepo;
        $this->accountRepo  = $accountRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoucherFilterRequest $request)
    {
        $fromDate       = !empty($request->get('from_date')) ? Carbon::createFromFormat('d-m-Y', $request->get('from_date'))->format('Y-m-d') : "";
        $toDate         = !empty($request->get('to_date')) ? Carbon::createFromFormat('d-m-Y', $request->get('to_date'))->format('Y-m-d') : "";
        $accountId      = $request->get('account_id');
        $debitReciept   = $request->get('transaction_type_debit');
        $creditVoucher  = $request->get('transaction_type_credit');
        $noOfRecords    = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

        $params = [
                [
                    'paramName'     => 'date',
                    'paramOperator' => '>=',
                    'paramValue'    => $fromDate,
                ],
                [
                    'paramName'     => 'date',
                    'paramOperator' => '<=',
                    'paramValue'    => $toDate,
                ],
                [
                    'paramName'     => 'transaction_type',
                    'paramOperator' => '=',
                    'paramValue'    => $debitReciept,
                    'paramValue1'   => $creditVoucher,
                ],
            ];

        $relationalOrParams = [
                [
                    'relation'      => 'transaction',
                    'paramName1'    => 'debit_account_id',
                    'paramName2'    => 'credit_account_id',
                    'paramValue'    => $accountId,
                ],
            ];

        $vouchers = $this->voucherRepo->getVouchers($params, $relationalOrParams, $noOfRecords);

        //params passing for auto selection
        $params[0]['paramValue'] = $request->get('from_date');
        $params[1]['paramValue'] = $request->get('to_date');
        $params = array_merge($params, $relationalOrParams);

        return view('vouchers.list', [
                'accounts'      => $this->accountRepo->getAccounts(),
                'vouchers'      => $vouchers,
                'params'        => $params,
                'noOfRecords'   => $noOfRecords,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts   = $this->accountRepo->getAccounts();

        return view('vouchers.register', [
                'accounts'  => $accounts,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRegistrationRequest $request)
    {
        $response   = $this->voucherRepo->saveVoucher($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Voucher/Reciept details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the voucher/reciept details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = $this->voucherRepo->getVoucher($id);

        return view('vouchers.details', [
                'voucher' => $voucher,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteFlag = $this->voucherRepo->deleteVoucher($id);

        if($deleteFlag) {
            return redirect(route('vouchers.index'))->with("message", "Voucher details deleted successfully.")->with("alert-class", "alert-success");
        }

        return redirect(route('vouchers.index'))->with("message", "Deletion failed.")->with("alert-class", "alert-danger");
    }
}
