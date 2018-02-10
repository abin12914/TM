<?php

namespace App\Repositories;

use App\Models\Settings;
use \Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;

class SettingsRepository
{

    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Return accounts.
     */
    public function getSettings()
    {
        $settings = $this->settings->find(1);
        if(empty($settings) || empty($settings->id)) {
            $settings = [];
        }

        return $settings;
    }

    /**
     * Action for saving settings.
     */
    public function updateSettings($request)
    {
        $validationRules    = [];
        $flag               = $request->get('settings_flag');
        $trackCertificate   = !empty($request->get('track_certificate')) ? $request->get('track_certificate') : 0;
        $defaultDte         = !empty($request->get('default_date')) ? Carbon::createFromFormat('d-m-Y', $request->get('default_date'))->format('Y-m-d') : null;

        $settings = $this->getSettings();

        if(!empty($flag) && $flag == 1) {
            $settings->track_certificate = $trackCertificate == 1 ? true : false;
            $validationRules    = ['track_certificate' => ['required', Rule::in([1, 0]) ] ];
        }
        if(!empty($flag) && $flag == 2) {
            $settings->default_date = $defaultDte;
            $validationRules    = ['default_date' => ['nullable','date_format:d-m-Y',]];
        }

        $validator = Validator::make($request->all(), $validationRules);

        if (!$validator->fails()) {
            if($settings->save()) {
                return [
                    'flag'  => true,
                ];
            }
        }

        return [
            'flag'  => false,
        ];
    }
}
