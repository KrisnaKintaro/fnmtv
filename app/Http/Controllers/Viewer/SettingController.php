<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function getSiteInfo()
    {
        $settings = Setting::whereIn('key', ['nama_situs', 'tagline'])
            ->pluck('value', 'key')
            ->toArray();

        return response()->json([
            'status' => 'success',
            'data' => [
                'nama_situs' => $settings['nama_situs'] ?? 'FNM',
                'tagline' => $settings['tagline'] ?? 'Fenomena News Media',
            ]
        ]);
    }
}