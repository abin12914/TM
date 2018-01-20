<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AccountRepository;
use App\Http\Requests\AccountRegistrationRequest;

class AccountController extends Controller
{
    protected $accountRepo;
    public $errorHead = 2;

    public $relationTypes = [
            1   => 'Supplier',
            2   => 'Customer',
            3   => 'Contractor',
            4   => 'General/Others',
            5   => 'Employees',
        ];

    public $accountTypes = [
            1   => 'Real',
            2   => 'Nominal',
            3   => 'Personal',
        ];

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepo  = $accountRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = $this->accountRepo->getAccounts(null, null, 15);
        
        return view('accounts.list', [
                'accounts'      => $accounts,
                'relationTypes' => $this->relationTypes,
                'accountTypes'  => $this->accountTypes,
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
        unset($this->relationTypes[5]);

        return view('accounts.register', [
                'relationTypes' => $this->relationTypes,
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
        //
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
        //
    }
}
