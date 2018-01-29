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
        $sites = [];
        
        $sites = Site::where('status', 1);

        foreach ($params as $key => $value) {
            if(!empty($value)) {
                $sites = $sites->where($key, $value);
            }
        }
        if(!empty($noOfRecords)) {
            $sites = $sites->paginate($noOfRecords);
        } else {
            $sites = $sites->get();
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

        return $site;
    }

    public function deleteSite($id)
    {
        $site = Site::where('status', 1)->where('id', $id)->first();

        if(!empty($site) && !empty($site->id)) {
            return $site->delete();
        }
        return false;
    }
}
