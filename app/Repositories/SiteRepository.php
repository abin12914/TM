<?php

namespace App\Repositories;

use App\Models\Site;

class SiteRepository
{
    public $siteTypes = [
            1   => 'Quarry',
            2   => 'Crusher Plant',
            3   => 'Construction Area',
            4   => 'Small Mining Area',
            5   => 'Residential Area'
        ];

    /**
     * Return accounts.
     */
    public function getSites($params=[], $noOfRecords=null)
    {
        $sites = Site::where('status', 1);

        foreach ($params as $key => $value) {
            if(!empty($value)) {
                $sites = $sites->where($key, $value);
            }
        }
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $sites = $sites->first();
            } else {
                $sites = $sites->paginate($noOfRecords);   
            }
        } else {
            $sites = $sites->get();
        }

        if(empty($sites) || $sites->count() < 1) {
            $sites = [];
        }

        return $sites;
    }

    /**
     * Action for saving accounts.
     */
    public function saveSite($request)
    {
        $siteName       = $request->get('site_name');
        $place          = $request->get('place');
        $address        = $request->get('address');
        $locationType   = $request->get('location_type');

        $site = new Site;
        $site->name         = $siteName;
        $site->place        = $place;
        $site->address      = $address;
        $site->site_type    = $locationType;
        $site->status       = 1;
        if($site->save()) {
            return [
                'flag'  => true,
                'id'    => $site->id
            ];
        }
        
        return [
            'flag'      => false,
            'errorCode' => "01"
        ];
    }

    /**
     * return account.
     */
    public function getSite($id)
    {
        $site = Site::where('status', 1)->where('id', $id)->first();

        if(empty($site) || empty($site->id)) {
            $site = [];
        }

        return $site;
    }

    public function deleteSite($id, $forceFlag=false)
    {
        $site = Site::where('status', 1)->where('id', $id)->first();

        if(!empty($site) && !empty($site->id)) {
            if($forceFlag) {
                if($site->forceDelete()) {
                    return [
                        'flag'  => true,
                        'force' => true,
                    ];
                } else {
                    $errorCode = '02';
                }
            } else {
                if($site->delete()) {
                    return [
                        'flag'  => true,
                        'force' => false,
                    ];
                } else {
                    $errorCode = '03';
                }
            }
        } else {
            $errorCode = '04';
        }
        return ['flag'      => false,
            'error_code'    => $errorCode,
        ];
    }
}
