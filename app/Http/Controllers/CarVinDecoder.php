<?php

namespace App\Http\Controllers;

use App\Services\WebScraperService;

class VehicleController extends Controller
{
    public function scrape()
    {
        $scraper = new WebScraperService();
        $data = $scraper->scrape('https://www.decodethis.com/vin/1FTFW1CF9DKD09801', [
            'container_selector' => '#vehicle-data',
            'section_selector' => 'section',
            'table_selector' => 'table',
        ]);
        
        return response()->json($data);
    }
}