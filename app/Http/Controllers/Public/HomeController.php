<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Support\PublicGallery;

class HomeController extends Controller
{
    public function index()
    {
        $gallery = PublicGallery::get();

        // On ne garde que les 4 premières montures pour la page d'accueil
        $monturesAccueil = array_slice($gallery['items'], 0, 4);

        return view('public.home', [
            'montures'       => $monturesAccueil,
            'montureFilters' => $gallery['filters'],
            'filterLabelMap' => $gallery['labels'],
        ]);
    }
}
