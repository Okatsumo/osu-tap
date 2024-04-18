<?php

namespace App\Http\Controllers;

use App\Models\Beatmapset;
use Illuminate\Http\Request;

class BeatmapsController extends Controller
{
    public function beatmaps()
    {
        $beatmapsets = Beatmapset::all();

        return view('maps', ['beatmapsets' => $beatmapsets]);
    }
}
