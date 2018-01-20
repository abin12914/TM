<?php

namespace App\Repositories;

use App\Models\Site;

class SiteRepository
{

    protected $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Return accounts.
     */
    public function getSites()
    {
        $sites = [];
        
        $sites = $this->site->where('status', 1)->paginate(15);

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
}
