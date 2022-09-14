<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddShowRequest;
use App\Http\Resources\ShowCollection;
use App\Http\Resources\ShowResource;
use App\Jobs\AddShow;
use App\Models\Show;

class ShowController extends Controller
{
    public function index(): ShowCollection
    {
        return new ShowCollection(Show::paginate(20));
    }

    public function getShow(int $showId): ShowResource
    {
        return new ShowResource(Show::find($showId));
    }

    public function request(AddShowRequest $request): ShowResource
    {
        AddShow::dispatch($request->imdbId);

        return new ShowResource(Show::latest()->first());
    }
}
