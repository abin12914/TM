<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ExpenseRepository;
use App\Repositories\TruckRepository;
use App\Repositories\AccountRepository;
use App\Http\Requests\ExpenseRegistrationRequest;

class ExpenseController extends Controller
{
    protected $expenseRepo;

     public function __construct(ExpenseRepository $expenseRepo)
    {
        $this->expenseRepo  = $expenseRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->expenseRepo->getExpences();
        
        return view('expenses.list', [
                'expenses' => $expenses,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TruckRepository $truckRepo, AccountRepository $accountRepo)
    {
        $trucks     = $truckRepo->getTrucks();
        $accounts   = $accountRepo->getAccounts();
        $services   = $this->expenseRepo->getServices();

        return view('expenses.register', [
                'trucks'    => $trucks,
                'accounts'  => $accounts,
                'services'  => $services,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRegistrationRequest $request)
    {
        $response   = $this->expenseRepo->saveExpense($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Expense details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the expense details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
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
