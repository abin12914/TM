<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TruckRepository;
use App\Http\Requests\TruckRegistrationRequest;

class TruckController extends Controller
{
    protected $truckRepo;
    public $errorHead = 1;

    public function __construct(TruckRepository $truckRepo)
    {
        $this->truckRepo    = $truckRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = $this->truckRepo->getTrucks();
        
        return view('trucks.list', [
                'trucks' => $trucks
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stateCodes = $this->truckRepo->getStateCodes();
        $truckTypes = $this->truckRepo->getTruckTypes();

        return view('trucks.register',[
                'truckTypes'    => $truckTypes,
                'stateCodes'    => $stateCodes
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
