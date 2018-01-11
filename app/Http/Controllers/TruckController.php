<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TruckRepository;
use App\Repositories\TruckTypeRepository;

class TruckController extends Controller
{
    protected $truckRepo, $truckTypeRepo;

    public function __construct(TruckRepository $truckRepo, TruckTypeRepository $truckTypeRepo)
    {
        $this->truckRepo        = $truckRepo;
        $this->truckTypeRepo    = $truckTypeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stateCodes = $this->truckRepo->getStateCodes();
        $truckTypes = $this->truckTypeRepo->getTruckTypes();

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
    public function store(Request $request)
    {
        $saveFlag   = $this->truckRepo->saveTruck($request);

        if($saveFlag) {
            return redirect()->back()->with("message","Truck details saved successfully.")->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the truck details. Try again after reloading the page!")->with("alert-class", "alert-danger");
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
