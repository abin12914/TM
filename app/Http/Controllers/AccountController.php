<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AccountRepository;
use App\Http\Requests\AccountRegistrationRequest;
use App\Http\Requests\AccountFilterRequest;

class AccountController extends Controller
{
    protected $accountRepo;
    public $errorHead = 2, $noOfRecordsPerPage = 15;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepo  = $accountRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AccountFilterRequest $request)
    {
        $accountRelation    = $request->get('relation_type');
        $accountId          = $request->get('account_id');
        $noOfRecords        = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

        $params = [
                'relation'          => $accountRelation,
                'id'                => $accountId,
            ];

        $accounts       = $this->accountRepo->getAccounts($params, $noOfRecords);
        $accountsCombo  = $this->accountRepo->getAccounts();
        
        return view('accounts.list', [
                'accountsCombo' => $accountsCombo,
                'accounts'      => $accounts,
                'relationTypes' => $this->accountRepo->relationTypes,
                'accountTypes'  => $this->accountRepo->accountTypes,
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
        //excluding the relationtype 'employee'[index = 5] for new account registration
        unset($this->accountRepo->relationTypes[5]);

        return view('accounts.register', [
                'relationTypes' => $this->accountRepo->relationTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRegistrationRequest $request)
    {
        $response   = $this->accountRepo->saveAccount($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Account details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the account details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = $this->accountRepo->getAccount($id);

        return view('accounts.details', [
                'account'       => $account,
                'relationTypes' => $this->accountRepo->relationTypes,
                'accountTypes'  => $this->accountRepo->accountTypes,
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
        $deleteFlag = $this->accountRepo->deleteAccount($id);

        if($deleteFlag) {
            return redirect(route('accounts.index'))->with("message", "Account details deleted successfully.")->with("alert-class", "alert-success");
        }

        return redirect(route('accounts.index'))->with("message", "Deletion failed.")->with("alert-class", "alert-danger");
    }
}
