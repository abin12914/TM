<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PurchaseRepository;
use App\Http\Requests\PurchaseAjaxRequests;

class PurchaseController extends Controller
{
    protected $purchaseRepo;
    public $errorHead = 5, $noOfRecordsPerPage = 15;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepo = $purchaseRepo;
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
    public function purchaseDetailsByCombo(PurchaseAjaxRequests $request)
    {
        $params = [];
        $relationalParams = [
                [
                    'relation'      => 'transaction',
                    'paramName'     => 'credit_account_id',
                    'paramValue'    => $request->get('supplier_account_id'),
                ],
                [
                    'relation'      => 'transportation',
                    'paramName'     => 'truck_id',
                    'paramValue'    => $request->get('truck_id'),
                ],
                [
                    'relation'      => 'transportation',
                    'paramName'     => 'source_id',
                    'paramValue'    => $request->get('source_id'),
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

        $lastPurchase = $this->purchaseRepo->getPurchase($params, $relationalParams, $order);

        if(!empty($lastPurchase) && !empty($lastPurchase->id)) {
            return [
                'flag'              => 'true',
                'measureType'       => $lastPurchase->measure_type,
                'purchaseQuantity'  => $lastPurchase->quantity,
                'purchaseRate'      => $lastPurchase->rate,
            ];
        }

        return [
            'flag' => 'false',
        ];
    }
}
