<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function sitemap()
    {

        return Sitemap::create()
            // ->add($post)
            ->add(Company::pluck('name'));

        // return SitemapGenerator::create('/companies')->getSitemap()->writeToDisk('public', 'sitemap.xml');
        // SitemapGenerator::create('/')->writeToFile('companies');


        //    return  Sitemap::create()

        //         ->add(Url::create('/')
        //             ->setLastModificationDate(Carbon::yesterday())
        //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
        //             ->setPriority(0.1))

        //         //    ->add(...)

        //         ->writeToFile('companies');


        // SitemapGenerator::create('https://example.com')->writeToFile('companies');

        // // creamos el nuevo objeto sitemap
        // $sitemap_contents = App::make("sitemap");
        // // establecer cache
        // $sitemap_contents->setCache('laravel.sitemap_contents', 3600);
        // // obtener todos los posts de la base de datos
        // $blogs = Company::orderBy('created_at', 'desc')->get();
        // // $blogs = Company::where('published', 1)->orderBy('created_at', 'desc')->get();
        // // agregar todos los posts al sitemap
        // foreach ($blogs as $blog) {
        //     $url = url('companies/' . $blog->id);
        //     $sitemap_contents->add($url, $blog->updated_at, '1.0', 'daily');
        // }
        // // mostrar el sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        // return $sitemap_contents->render('xml');
    }
}
