<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplyRepository;
use App\Repositories\TransportationRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use App\Repositories\EmployeeWageRepository;
use App\Http\Requests\SupplyRegistrationRequest;
use App\Http\Requests\TransportationFilterRequest;
use \Carbon\Carbon;

class SupplyController extends Controller
{
    protected $supplyRepo, $transportationRepo;
    public $errorHead = 6, $noOfRecordsPerPage = 15;
    
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

        $supplyTransportations = $this->supplyRepo->getSupplyTransportations($params, $relationalParams, $noOfRecords);

        //params passing for auto selection
        $params[0]['paramValue'] = $request->get('from_date');
        $params[1]['paramValue'] = $request->get('to_date');
        $params = array_merge($params, $relationalParams);
        
        return view('supply.list', [
                'materials'             => $this->transportationRepo->getMaterials(),
                'supplyTransportations' => $supplyTransportations,
                'rentTypes'             => $this->transportationRepo->rentTypes,
                'params'                => $params,
                'noOfRecords'           => $noOfRecords,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supply.register', [
                'materials'     => $this->transportationRepo->getMaterials(),
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
    public function store(SupplyRegistrationRequest $request, PurchaseRepository $purchaseRepo, SaleRepository $saleRepo, EmployeeWageRepository $employeeWageRepo)
    {
        $saveFlag  = 0;
        $errorCode = 0;
        $noOfTrip  = !empty($request->get('no_of_trip')) ? $request->get('no_of_trip') : 1;

        for($i = 1; $i <= $noOfTrip; $i++) {

            $transportation = $this->transportationRepo->saveTransportation($request);

            if($transportation['flag']) {

                $employeeWage = $employeeWageRepo->saveEmployeeWage($request, $transportation['id']);
                
                if($employeeWage['flag']) {

                    $purchase = $purchaseRepo->savePurchase($request, $transportation['id']);

                    if($purchase['flag']) {

                        $sale = $saleRepo->saveSale($request, $transportation['id']);

                        if($sale['flag']) {

                            $saveFlag = $saveFlag + 1;
                        } else {
                            //delete purchase
                            $purchaseRepo->deletePurchase($purchase['id'], true);
                            //delete employee wage
                            $deleteEmployeeWage = $employeeWageRepo->deleteEmployeeWage($transportation['id'], true);
                            //delete transportation
                            $this->transportationRepo->deleteTransportation($transportation['id'], true);

                            $errorCode = '/04/'.$sale['errorCode'];
                            break;
                        }
                    } else {
                        //delete employee wage
                        $deleteEmployeeWage = $employeeWageRepo->deleteEmployeeWage($transportation['id'], true);
                        //delete transportation
                        $this->transportationRepo->deleteTransportation($transportation['id'], true);

                        $errorCode = '/03/'.$purchase['errorCode'];
                        break;
                    }
                } else {
                    //delete transportation if employee wage saving failed
                    $this->transportationRepo->deleteTransportation($transportation['id'], true);

                    $errorCode = '/02/'.$employeeWage['errorCode'];
                    break;
                }
            } else {
                $errorCode = '/01/'.$employeeWage['errorCode'];
                break;
            }
        }

        if ($saveFlag == $noOfTrip) {
            return redirect()->back()->with("message", $saveFlag. " - Supply details saved successfully. Reference Number : ". $transportation['id'])->with("alert-class", "alert-success");
        } else {
            return redirect()->back()->with("message",$saveFlag. " - Records saved.". ($noOfTrip - $saveFlag)." - Records failed. Error Code : XXX/". $this->errorHead.$errorCode)->with("alert-class", "alert-danger");
        }

        

        return redirect()->back()->withInput()->with("message","Failed to save the supply details. Error Code : ". $this->errorHead. "/01/". $transportation['errorCode'])->with("alert-class", "alert-danger");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplyTransportation = $this->supplyRepo->getSupplyTransportation($id);
        if(empty($supplyTransportation) || empty($supplyTransportation->id)) {
            $supplyTransportation = [];
        }
        
        return view('supply.details', [
                'supplyTransportation'  => $supplyTransportation,
                'rentTypes'             => $this->transportationRepo->rentTypes,
                'measureTypes'          => $this->supplyRepo->measureTypes,
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
    public function destroy($id, PurchaseRepository $purchaseRepo, SaleRepository $saleRepo, EmployeeWageRepository $employeeWageRepo)
    {
        $supplyTransportation = $this->supplyRepo->getSupplyTransportation($id);

        if(!empty($supplyTransportation) && !empty($supplyTransportation->id)) {
            
            $purchaseDelete = $purchaseRepo->deletePurchase($supplyTransportation->purchase->id);
            if($purchaseDelete['flag']) {
                
                $saleDelete = $saleRepo->deleteSale($supplyTransportation->sale->id);
                if($saleDelete['flag']) {

                    $employeeWageDelete = $employeeWageRepo->deleteEmployeeWage($supplyTransportation->employeeWage->id);
            
                    if($employeeWageDelete['flag']) {
                    
                        $transportationDelete = $this->transportationRepo->deleteTransportation($supplyTransportation->id);
                        if($transportationDelete['flag']) {
                            
                            return redirect(route('supply.index'))->with("message", "Supply details deleted successfully.")->with("alert-class", "alert-success");
                        } else {
                            
                            $deleteFlag = "04 / ". $transportationDelete['errorCode'];
                        }
                    } else {
                        $deleteFlag = "03 / ". $employeeWageDelete['errorCode'];
                    }
                } else {

                    $deleteFlag = "02 / ". $saleDelete['errorCode'];
                }
            } else {

                $deleteFlag = "01 / ". $purchaseDelete['errorCode'];
            }
        } else {

            $deleteFlag = "05";
        }

        return redirect(route('supply.index'))->with("message", "Deletion failed. Error Code : ". $this->errorHead. " / ". $deleteFlag)->with("alert-class", "alert-danger");
    }
}
