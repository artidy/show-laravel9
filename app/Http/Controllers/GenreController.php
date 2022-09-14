<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreUpdateRequest;
use App\Http\Resources\GenreCollection;
use App\Http\Resources\GenreResource;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index(): GenreCollection
    {
        return new GenreCollection(Genre::all());
    }

    public function update(GenreUpdateRequest $request, Genre $genre): GenreResource
    {
        $genre->update($request->validated());

        return new GenreResource($genre->fresh());
    }
}
