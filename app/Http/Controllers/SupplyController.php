<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplyRepository;
use App\Repositories\TransportationRepository;
use App\Repositories\TruckRepository;
use App\Repositories\AccountRepository;
use App\Repositories\SiteRepository;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\SupplyRegistrationRequest;

class SupplyController extends Controller
{
    protected $supplyRepo, $transportationRepo;
    public $errorHead = 6;
    
    public function __construct(SupplyRepository $supplyRepo, TransportationRepository $transportationRepo)
    {
        $this->supplyRepo           = $supplyRepo;
        $this->transportationRepo   = $transportationRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return view('supply.register', [
                'trucks'        => $trucks,
                'accounts'      => $accounts,
                'sites'         => $sites,
                'employees'     => $employees,
                'materials'     => $materials,
                'rentTypes'     => $this->transportationRepo->rentTypes,
                'measureTypes'  => $this->supplyRepo->measureTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplyRegistrationRequest $request)
    {
        $response   = $this->transportationRepo->saveTransportation($request);

        if($response['flag']) {
            
        }
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
