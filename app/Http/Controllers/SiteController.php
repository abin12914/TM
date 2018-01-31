<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SiteRepository;
use App\Http\Requests\SiteRegistrationRequest;
use App\Http\Requests\SiteFilterRequest;

class SiteController extends Controller
{
    protected $siteRepo;
    public $errorHead = 4, $noOfRecordsPerPage = 15;

    public function __construct(SiteRepository $siteRepo)
    {
        $this->siteRepo    = $siteRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SiteFilterRequest $request)
    {
        $noOfRecords    = !empty($request->get('no_of_records')) ? $request->get('no_of_records') : $this->noOfRecordsPerPage;

        $params = [
            'site_type' => $request->get('site_type'),
            'id'        => $request->get('site_id'),
        ];

        return view('sites.list', [
                'sitesCombo'    => $this->siteRepo->getSites(),
                'sites'         => $this->siteRepo->getSites($params, $noOfRecords),
                'siteTypes'     => $this->siteRepo->siteTypes,
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
        return view('sites.register', [
                'siteTypes' => $this->siteRepo->siteTypes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRegistrationRequest $request)
    {
        $response   = $this->siteRepo->saveSite($request);

        if($response['flag']) {
            return redirect()->back()->with("message","Site details saved successfully. Reference Number : ". $response['id'])->with("alert-class", "alert-success");
        }
        
        return redirect()->back()->with("message","Failed to save the site details. Error Code : ". $response['errorCode'])->with("alert-class", "alert-danger");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('sites.details', [
                'site'      => $this->siteRepo->getSite($id),
                'siteTypes' => $this->siteRepo->siteTypes,
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
        $deleteFlag = $this->siteRepo->deleteSite($id);

        if($deleteFlag['flag']) {
            return redirect(route('sites.index'))->with("message", "Site details deleted successfully.")->with("alert-class", "alert-success");
        }

        return redirect(route('sites.index'))->with("message", "Deletion failed. Error Code : ". $errorHead. " / ". $deleteFlag['errorCode'])->with("alert-class", "alert-danger");
    }
}
