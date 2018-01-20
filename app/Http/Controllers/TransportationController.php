<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransportationRepository;
use App\Repositories\TruckRepository;
use App\Repositories\AccountRepository;
use App\Repositories\SiteRepository;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\TransportationRegistrationRequest;

class TransportationController extends Controller
{
    protected $transportationRepo;
    public $errorHead = 5;

    public function __construct(TransportationRepository $transportationRepo)
    {
        $this->transportationRepo   = $transportationRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transportations = $this->transportationRepo->getTransportations();
        
        return view('transportations.list', [
                'transportations' => $transportations,
                'rentTypes' => $this->transportationRepo->rentTypes,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TruckRepository $truckRepo, AccountRepository $accountRepo, SiteRepository $siteRpepo, EmployeeRepository $employeeRepo)
    {
        $trucks     = $truckRepo->getTrucks();
        $accounts   = $accountRepo->getAccounts();
        $sites      = $siteRpepo->getSites();
        $employees  = $employeeRepo->getEmployees();
        $materials  = $this->transportationRepo->getMaterials();

        return view('transportations.register', [
                'trucks'    => $trucks,
                'accounts'  => $accounts,
                'sites'     => $sites,
                'employees' => $employees,
                'materials' => $materials,
                'rentTypes' => $this->transportationRepo->rentTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransportationRegistrationRequest $request)
    {
        $response   = $this->transportationRepo->saveTransportation($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Transportation details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the transportation details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
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
