<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TruckRepository;
use App\Http\Requests\TruckRegistrationRequest;
use App\Http\Requests\TruckFilterRequest;
use \Carbon\Carbon;

class TruckController extends Controller
{
    protected $truckRepo;
    public $errorHead = 1, $noOfRecordsPerPage = 15;

    public function __construct(TruckRepository $truckRepo)
    {
        $this->truckRepo    = $truckRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TruckFilterRequest $request)
    {
        $noOfRecords = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

        $params = [
            'truck_type_id' => $request->get('truck_type_id'),
            'id'            => $request->get('truck_id'),
        ];
        
        return view('trucks.list', [
                'trucksCombo'   => $this->truckRepo->getTrucks(),
                'trucks'        => $this->truckRepo->getTrucks($params, $noOfRecords),
                'truckTypes'    => $this->truckRepo->getTruckTypes(),
                'bodyTypes'     => $this->truckRepo->bodyTypes,
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
        return view('trucks.register',[
                'truckTypes'    => $this->truckRepo->getTruckTypes(),
                'stateCodes'    => $this->truckRepo->getStateCodes(),
                'bodyTypes'     => $this->truckRepo->bodyTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TruckRegistrationRequest $request)
    {
        $response   = $this->truckRepo->saveTruck($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Truck details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the truck details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insuranceFlag  = 'orange';
        $taxFlag        = 'orange';
        $fitnessFlag    = 'orange';
        $permitFlag     = 'orange';

        $flagValues = [
                1   => 'green',
                2   => 'orange',
                3   => 'red',
            ];

        $truck = $this->truckRepo->getTruck($id);

        $validity = $this->truckRepo->checkCertificateValidity($truck);

        if($validity['flag']) {
            $insuranceFlag  = $flagValues[$validity['insuranceFlag']];
            $taxFlag        = $flagValues[$validity['taxFlag']];
            $fitnessFlag    = $flagValues[$validity['fitnessFlag']];
            $permitFlag     = $flagValues[$validity['permitFlag']];
        }
        
        return view('trucks.details', [
                'truck'         => $truck,
                'bodyTypes'     => $this->truckRepo->bodyTypes,
                'insuranceFlag' => $insuranceFlag,
                'taxFlag'       => $taxFlag,
                'fitnessFlag'   => $fitnessFlag,
                'permitFlag'    => $permitFlag,
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
        $deleteFlag = $this->truckRepo->deleteTruck($id);

        if($deleteFlag['flag']) {
            return redirect(route('trucks.index'))->with("message", "Truck details deleted successfully.")->with("alert-class", "alert-success");
        }

        return redirect(route('trucks.index'))->with("message", "Deletion failed. Error Code :". $deleteFlag['errorCode'])->with("alert-class", "alert-danger");
    }
}
