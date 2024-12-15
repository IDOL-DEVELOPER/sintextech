<?php

namespace App\Http\Controllers\manifest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManifestController extends Controller
{
   public function index()
{
    $settings = [
        "id" => "/manifest.json",
        "name" => setting('site_name'),
        "short_name" => setting('site_short_name'),
        "start_url" => "/",
        "display" => "standalone",
        "background_color" => setting('primary-color'),
        "theme_color" => setting('primary-color'),
        "description" => setting('site_discription'),
        "icons" => [
            [
                "src" => asset(webData()->favicon->external_link ?? ''),
                "type" => "image/png",
                "sizes" => "192x192",
            ],
            [
                "src" => asset(webData()->favicon->external_link ?? ''),
                "type" => "image/png",
                "sizes" => "512x512",
            ],
        ],
        "screenshots" => [
            [
                "src" => asset(webData()->favicon->external_link ?? ''), // Use `asset()` for correct URL generation
                "sizes" => "1080x1920",
                "type" => "image/png",
                "form_factor" => "narrow",
            ],
            [
                "src" => asset(webData()->favicon->external_link ?? ''),
                "sizes" => "1920x1080",
                "type" => "image/png",
                "form_factor" => "wide",
            ],
        ],
    ];

    return response()->json($settings, 200, ['Content-Type' => 'application/json']);
}

}
