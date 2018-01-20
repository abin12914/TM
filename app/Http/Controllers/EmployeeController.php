<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\EmployeeRegistrationRequest;

class EmployeeController extends Controller
{
    protected $employeeRepo;
    public $errorHead = 3;

    public $wageTypes = [
            1   =>  'Monthly Salary',
            2   =>  'Daily Wage',
            3   =>  'Trip Bata',
        ];

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo  = $employeeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeeRepo->getEmployees();
        
        return view('employees.list', [
                'employees' => $employees,
                'wageTypes' => $this->wageTypes,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.register', [
                'wageTypes' => $this->wageTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRegistrationRequest $request)
    {
        $response   = $this->employeeRepo->saveEmployee($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Employee details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the employee details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
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
