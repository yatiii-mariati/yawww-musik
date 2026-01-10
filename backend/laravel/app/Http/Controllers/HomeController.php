<?php

namespace App\Http\Controllers;

use App\Models\Artist;

class HomeController extends Controller
{
    public function index()
    {
        $artists = Artist::with([
            'albums.songs'
        ])->get();

        return view('frontend.home', compact('artists'));
    }
}
