<?php

namespace App\Http\Controllers;

use App\Http\Resources\EpisodeCollection;
use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use App\Models\Show;

class EpisodeController extends Controller
{
    public function index(Show $show): EpisodeCollection
    {
        return new EpisodeCollection($show->episodes);
    }

    public function episode(Episode $episode): EpisodeResource
    {
        return new EpisodeResource($episode);
    }
}
