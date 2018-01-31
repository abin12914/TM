<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\Transportation;
use App\Models\Sale;
use App\Models\Account;
use App\Models\Transaction;
use \Carbon\Carbon;
use Auth;

class SupplyRepository
{
    public $measureTypes = [
            1   => 'Weighment [Ton]',
            2   => 'Volume [Feet]',
            3   => 'Fixed For TruckType',
        ];

    /**
     * Return supply transportation.
     */
    public function getSupplyTransportations($params=[], $relationalParams=[], $noOfRecords=null)
    {
        //transportations that has related purchase and sale [supply]
        $supplyTransportations = Transportation::where('status', 1)->has('purchase')->has('sale');

        foreach ($params as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $supplyTransportations = $supplyTransportations->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
            }
        }


        foreach ($relationalParams as $param) {
            if(!empty($param) && !empty($param['paramValue'])) {
                $supplyTransportations = $supplyTransportations->whereHas($param['relation'], function($qry) use($param) {
                    $qry->where($param['paramName'], $param['paramValue']);
                });
            }
        }
        
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $supplyTransportations = $supplyTransportations->first();
            } else {
                $supplyTransportations = $supplyTransportations->paginate($noOfRecords);
            }

        } else {
            $supplyTransportations= $supplyTransportations->get();
        }

        if(empty($supplyTransportations) || $supplyTransportations->count() < 1) {
            $supplyTransportations = [];
        }

        return $supplyTransportations;
    }

    /**
     * Return supply transportation.
     */
    public function getSupplyTransportation($id)
    {
        //transportations that has related purchase and sale [supply]
        $supplyTransportation = Transportation::where('status', 1)->where('id', $id)->has('purchase')->has('sale')->first();
        if(empty($supplyTransportation) || $supplyTransportation->count() < 1) {
            $supplyTransportation = [];
        }

        return $supplyTransportation;
    }
}
