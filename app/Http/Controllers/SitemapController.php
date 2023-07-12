<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL as FacadesURL;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function sitemap()
    {

        $baseUrl = FacadesURL::to('/');

        SitemapGenerator::create($baseUrl)
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->setMaximumDepth(1);
            })
            ->writeToFile(public_path() . '/sitemap.xml');

        $sitemapPath = public_path('sitemap.xml');
        $content = file_get_contents($sitemapPath);

        return Response::make($content, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
