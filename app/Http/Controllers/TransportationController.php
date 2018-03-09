<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransportationRepository;
use App\Repositories\EmployeeWageRepository;
use App\Http\Requests\TransportationRegistrationRequest;
use App\Http\Requests\TransportationFilterRequest;
use App\Http\Requests\TransportationAjaxRequests;
use \Carbon\Carbon;

class TransportationController extends Controller
{
    protected $transportationRepo;
    public $errorHead = 5, $noOfRecordsPerPage = 15;

    public function __construct(TransportationRepository $transportationRepo)
    {
        $this->transportationRepo = $transportationRepo;
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
                    'paramValue'    => $request->get('truck_id'),
                ],
                [
                    'paramName'     => 'source_id',
                    'paramOperator' => '=',
                    'paramValue'    => $request->get('source_id'),
                ],
                [
                    'paramName'     => 'destination_id',
                    'paramOperator' => '=',
                    'paramValue'    => $request->get('destination_id'),
                ],
                [
                    'paramName'     => 'driver_id',
                    'paramOperator' => '=', 
                    'paramValue'    => $request->get('driver_id'),
                ],
                [
                    'paramName'     => 'material_id',
                    'paramOperator' => '=', 
                    'paramValue'    => $request->get('material_id'),
                ],
            ];

        $relationalParams = [
                [
                    'relation'      => 'transaction',
                    'paramName'     => 'debit_account_id',
                    'paramValue'    => $request->get('contractor_account_id'),
                ]
            ];

        $transportations = $this->transportationRepo->getTransportations($params, $relationalParams, $noOfRecords);

        //params passing for auto selection
        $params[0]['paramValue'] = $request->get('from_date');
        $params[1]['paramValue'] = $request->get('to_date');
        $params = array_merge($params, $relationalParams);
        
        return view('transportations.list', [
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
        return view('transportations.register', [
                'materials' => $this->transportationRepo->getMaterials(),
                'rentTypes' => $this->transportationRepo->rentTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransportationRegistrationRequest $request, EmployeeWageRepository $employeeWageRepo)
    {
        $saveFlag  = 0;
        $errorCode = 0;
        $noOfTrip  = !empty($request->get('no_of_trip')) ? $request->get('no_of_trip') : 1;

        for($i = 1; $i <= $noOfTrip; $i++) {
            $transportation = $this->transportationRepo->saveTransportation($request);

            if($transportation['flag']) {

                $employeeWage = $employeeWageRepo->saveEmployeeWage($request, $transportation['id']);
                if($employeeWage['flag']) {
                    $saveFlag = $saveFlag + 1;
                } else {

                    $this->transportationRepo->deleteTransportation($transportation['id'], true);
                    $errorCode = '/02/'.$employeeWage['errorCode'];
                    break;
                }
            } else {
                $errorCode = '/01/'.$transportation['errorCode'];
                break;
            }
        }
        
        if ($saveFlag == $noOfTrip) {
            return redirect()->back()->with("message", $saveFlag. " - Transportation details saved successfully. Reference Number : ". $transportation['id'])->with("alert-class", "alert-success");
        } else {
            return redirect()->back()->with("message",$saveFlag. " - Records saved.". ($noOfTrip - $saveFlag)." - Records failed. Error Code : XXX/". $this->errorHead.$errorCode)->with("alert-class", "alert-danger");
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
        $params = [
                [
                    'paramName'     => 'id',
                    'paramOperator' => '=',
                    'paramValue'    => $id,
                ]
            ];
        return view('transportations.details', [
                'transportation'    => $this->transportationRepo->getTransportation($params, [], []),
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
    public function destroy($id, EmployeeWageRepository $employeeWageRepo)
    {
        $params = [
                [
                    'paramName'     => 'id',
                    'paramOperator' => '=',
                    'paramValue'    => $id,
                ]
            ];

        $transportation = $this->transportationRepo->getTransportation($params, [], []);

        if(!empty($transportation) && !empty($transportation->id)) {
            $deleteEmployeeWage = $employeeWageRepo->deleteEmployeeWage($transportation->employeeWage->id);

            if($deleteEmployeeWage['flag']) {
                $deleteTransportationFlag = $this->transportationRepo->deleteTransportation($id);

                if($deleteTransportationFlag['flag']) {
                    return redirect(route('transportations.index'))->with("message", "Transportation details deleted successfully.")->with("alert-class", "alert-success");
                } else {
                    $errorCode = '03/'. $deleteTransportationFlag['errorCode'];
                }
            } else {
                $errorCode = '04/'. $deleteEmployeeWage['errorCode'];
            }
        } else {
            $errorCode = '05';
        }

        return redirect(route('transportations.index'))->with("message", "Deletion failed. Error Code : ". $this->errorHead. " / ". $errorCode)->with("alert-class", "alert-danger");
    }

    /**
     * get driver id for selected truck from previous data
     *
     */
    public function driverByTruck(TransportationAjaxRequests $request)
    {
        $params = [
            [
                'paramName'     => 'truck_id',
                'paramOperator' => '=',
                'paramValue'    => $request->get('truck_id'),
            ]
        ];

        $order  = [
            'order_key'     => 'date',
            'order_type'    => 'desc'
         ];

        $lastTransportation = $this->transportationRepo->getTransportation($params, [], $order);

        if(!empty($lastTransportation) && !empty($lastTransportation->id)) {
            return [
                'flag'      => 'true',
                'driverId'  => $lastTransportation->driver_id
            ];
        }
        return [
            'flag' => 'false',
        ];
    }

    /**
     * get contractor id for selected sites from previous data
     *
     */
    public function contractorBySite(TransportationAjaxRequests $request)
    {
        $params = [
            [
                'paramName'     => 'source_id',
                'paramOperator' => '=',
                'paramValue'    => $request->get('source_id'),
            ],
            [
                'paramName'     => 'destination_id',
                'paramOperator' => '=',
                'paramValue'    => $request->get('destination_id'),
            ]
        ];

        $order  = [
            'order_key'     => 'date',
            'order_type'    => 'desc'
         ];

        $lastTransportation = $this->transportationRepo->getTransportation($params, [], $order);

        if(!empty($lastTransportation) && !empty($lastTransportation->id)) {
            return [
                'flag'                  => 'true',
                'contractorAccountId'   => $lastTransportation->transaction->debit_account_id,
            ];
        }
        return [
            'flag' => 'false',
        ];
    }

    /**
     * get rent type for selected sites, contractor and truck from previous data
     *
     */
    public function rentDetailByCombo(TransportationAjaxRequests $request)
    {
        $params = [
            [
                'paramName'     => 'truck_id',
                'paramOperator' => '=',
                'paramValue'    => $request->get('truck_id'),
            ],
            [
                'paramName'     => 'source_id',
                'paramOperator' => '=',
                'paramValue'    => $request->get('source_id'),
            ],
            [
                'paramName'     => 'destination_id',
                'paramOperator' => '=',
                'paramValue'    => $request->get('destination_id'),
            ]
        ];

        $order  = [
            'order_key'     => 'date',
            'order_type'    => 'desc'
         ];

        $relationalParams = [
            [
                'relation'      => 'transaction',
                'paramName'     => 'debit_account_id',
                'paramValue'    => $request->get('contractor_account_id'),
            ]
        ];

        $lastTransportation = $this->transportationRepo->getTransportation($params, $relationalParams, $order);

        if(!empty($lastTransportation) && !empty($lastTransportation->id)) {
            return [
                'flag'          => 'true',
                'rentType'      => $lastTransportation->rent_type,
                'rentRate'      => $lastTransportation->rent_rate,
                'materialId'    => $lastTransportation->material_id,
            ];
        }

        return [
            'flag' => 'false',
        ];
    }
}
