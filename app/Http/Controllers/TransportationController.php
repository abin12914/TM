<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransportationRepository;
use App\Repositories\TruckRepository;
use App\Repositories\AccountRepository;
use App\Repositories\SiteRepository;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\TransportationRegistrationRequest;
use App\Http\Requests\TransportationFilterRequest;
use \Carbon\Carbon;

class TransportationController extends Controller
{
    protected $transportationRepo, $truckRepo, $accountRepo, $siteRpepo, $employeeRepo;
    public $errorHead = 5, $noOfRecordsPerPage = 15;

    public function __construct(TransportationRepository $transportationRepo, TruckRepository $truckRepo, AccountRepository $accountRepo, SiteRepository $siteRpepo, EmployeeRepository $employeeRepo)
    {
        $this->transportationRepo   = $transportationRepo;
        $this->truckRepo            = $truckRepo;
        $this->accountRepo          = $accountRepo;
        $this->siteRpepo            = $siteRpepo;
        $this->employeeRepo         = $employeeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransportationFilterRequest $request)
    {
        $fromDate            = !empty($request->get('from_date')) ? Carbon::createFromFormat('d-m-Y', $request->get('from_date'))->format('Y-m-d') : "";
        $toDate              = !empty($request->get('to_date')) ? Carbon::createFromFormat('d-m-Y', $request->get('to_date'))->format('Y-m-d') : "";
        $contractorAccountId = $request->get('contractor_account_id');
        $truckId             = $request->get('truck_id');
        $sourceId            = $request->get('source_id');
        $destinationId       = $request->get('destination_id');
        $driverId            = $request->get('driver_id');
        $materialId          = $request->get('material_id');
        $noOfRecords         = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

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
                    'paramName'     => 'truck_id',
                    'paramOperator' => '=',
                    'paramValue'    => $truckId,
                ],
                [
                    'paramName'     => 'source_id',
                    'paramOperator' => '=',
                    'paramValue'    => $sourceId,
                ],
                [
                    'paramName'     => 'destination_id',
                    'paramOperator' => '=',
                    'paramValue'    => $destinationId,
                ],
                [
                    'paramName'     => 'driver_id',
                    'paramOperator' => '=', 
                    'paramValue'    => $driverId,
                ],
                [
                    'paramName'     => 'material_id',
                    'paramOperator' => '=', 
                    'paramValue'    => $materialId,
                ],
            ];

        $relationalParams = [
                [
                    'relation'      => 'transaction',
                    'paramName'     => 'debit_account_id',
                    'paramValue'    => $contractorAccountId,
                ]
            ];

        $transportations = $this->transportationRepo->getTransportations($params, $relationalParams, $noOfRecords);

        //params passing for auto selection
        $params[0]['paramValue'] = $request->get('from_date');
        $params[1]['paramValue'] = $request->get('to_date');
        $params = array_merge($params, $relationalParams);
        /*array_push($params, $relationalParams[0]);*/
        
        return view('transportations.list', [
                'accounts'          => $this->accountRepo->getAccounts(),
                'sites'             => $this->siteRpepo->getSites(),
                'trucks'            => $this->truckRepo->getTrucks(),
                'drivers'           => $this->employeeRepo->getEmployees(),
                'materials'         => $this->transportationRepo->getMaterials(),
                'transportations'   => $transportations,
                'rentTypes'         => $this->transportationRepo->rentTypes,
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
        $trucks     = $this->truckRepo->getTrucks();
        $accounts   = $this->accountRepo->getAccounts();
        $sites      = $this->siteRpepo->getSites();
        $employees  = $this->employeeRepo->getEmployees();
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
        $transportation = $this->transportationRepo->getTransportation($id);

        return view('transportations.details', [
                'transportation'    => $transportation,
                'rentTypes'         => $this->transportationRepo->rentTypes,
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
        $deleteFlag = $this->transportationRepo->deleteTransportation($id);

        if($deleteFlag) {
            return redirect(route('transportations.index'))->with("message", "Transportation details deleted successfully.")->with("alert-class", "alert-success");
        }

        return redirect(route('transportations.index'))->with("message", "Deletion failed.")->with("alert-class", "alert-danger");
    }
}
