<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Support\PublicGallery;

class HomeController extends Controller
{
    public function index()
    {
        $gallery = PublicGallery::get();

        return view('public.home', [
            'montures'       => $gallery['items'],
            'montureFilters' => $gallery['filters'],
            'filterLabelMap' => $gallery['labels'],
        ]);
    }
}
