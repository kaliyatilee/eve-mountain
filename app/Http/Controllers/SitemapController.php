<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $pages = [
            ['url' => route('home'),           'priority' => '1.0',  'changefreq' => 'weekly'],
            ['url' => route('facilities'),      'priority' => '0.9',  'changefreq' => 'monthly'],
            ['url' => route('activities'),      'priority' => '0.9',  'changefreq' => 'monthly'],
            ['url' => route('gallery'),         'priority' => '0.8',  'changefreq' => 'weekly'],
            ['url' => route('contact'),         'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => route('booking.create'),  'priority' => '0.95', 'changefreq' => 'monthly'],
        ];

        $xml = view('sitemap', compact('pages'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}