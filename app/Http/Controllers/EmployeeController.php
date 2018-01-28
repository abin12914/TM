<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\EmployeeRegistrationRequest;
use App\Http\Requests\EmployeeFilterRequest;

class EmployeeController extends Controller
{
    protected $employeeRepo;
    public $errorHead = 3, $noOfRecordsPerPage = 15;

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo  = $employeeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeeFilterRequest $request)
    {
        $wageType       = $request->get('wage_type');
        $employeeId     = $request->get('employee_id');
        $noOfRecords    = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

        $params = [
                'wage_type' => $wageType,
                'id'        => $employeeId,
            ];

        $employees      = $this->employeeRepo->getEmployees($params, $noOfRecords);
        $employeesCombo = $this->employeeRepo->getEmployees();
        
        return view('employees.list', [
                'employeesCombo'    => $employeesCombo,
                'employees'         => $employees,
                'wageTypes'         => $this->employeeRepo->wageTypes,
                'params'            => $params,
                'noOfRecords'       => $noOfRecords,
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
                'wageTypes' => $this->employeeRepo->wageTypes,
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
        $employee = $this->employeeRepo->getEmployee($id);

        return view('employees.details', [
                'employee'  => $employee,
                'wageTypes' => $this->employeeRepo->wageTypes,
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
        $deleteFlag = $this->employeeRepo->deleteEmployee($id);

        if($deleteFlag) {
            return redirect(route('employees.index'))->with("message", "Employee details deleted successfully.")->with("alert-class", "alert-success");
        }

        return redirect(route('employees.index'))->with("message", "Deletion failed.")->with("alert-class", "alert-danger");
    }
}
