<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SaleRepository;
use App\Http\Requests\SaleAjaxRequests;

class SaleController extends Controller
{
    protected $saleRepo;
    public $errorHead = 5, $noOfRecordsPerPage = 15;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepo = $saleRepo;
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * get purchase detail by truck, source and supplier
     *
     */
    public function saleDetailsByCombo(SaleAjaxRequests $request)
    {
        $params = [];
        $relationalParams = [
                [
                    'relation'      => 'transaction',
                    'paramName'     => 'debit_account_id',
                    'paramValue'    => $request->get('customer_account_id'),
                ],
                [
                    'relation'      => 'transportation',
                    'paramName'     => 'truck_id',
                    'paramValue'    => $request->get('truck_id'),
                ],
                [
                    'relation'      => 'transportation',
                    'paramName'     => 'destination_id',
                    'paramValue'    => $request->get('destination_id'),
                ],
                [
                    'relation'      => 'transportation',
                    'paramName'     => 'material_id',
                    'paramValue'    => $request->get('material_id'),
                ],
            ];

            $order  = [
                'order_key'     => 'date',
                'order_type'    => 'desc'
             ];

        $lastSale = $this->saleRepo->getSale($params, $relationalParams, $order);

        if(!empty($lastSale) && !empty($lastSale->id)) {
            return [
                'flag'          => 'true',
                'measureType'   => $lastSale->measure_type,
                'saleQuantity'  => $lastSale->quantity,
                'saleRate'      => $lastSale->rate,
            ];
        }

        return [
            'flag' => 'false',
        ];
    }
}
