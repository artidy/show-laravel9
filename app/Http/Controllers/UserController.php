<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\VoteRequest;
use App\Http\Resources\EpisodeCollection;
use App\Http\Resources\EpisodeResource;
use App\Http\Resources\ShowCollection;
use App\Http\Resources\ShowResource;
use App\Http\Resources\UserResource;
use App\Models\Episode;
use App\Models\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(UserRequest $request): UserResource
    {
        $params = $request->safe()->except('file');

        $user = Auth::user();
        $path = false;

        if ($request->hasFile('file')) {
            $oldFile = $user->avatar;
            $result = $request->file('file')->store('avatars', 'public');
            $path = $result ? $request->file('file')->hashName() : false;
            $params['avatar'] = $path;
        }

        $user->update($params);

        if ($path && $oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

        return new UserResource(Auth::user()->makeVisible('email'));
    }

    public function shows(): ShowCollection
    {
        return new ShowCollection(Auth::user()->shows->paginate(20));
    }

    public function unwatchedEpisodes(Show $show): EpisodeCollection
    {
        return new EpisodeCollection(Auth::user()->unwatchedEpisodes($show));
    }

    public function addToWatchList(Show $show): ShowResource
    {
        Auth::user()->shows()->attach($show);

        return new ShowResource($show);
    }

    public function removeFromWatchList(Show $show): ShowResource
    {
        Auth::user()->shows()->detach($show);

        return new ShowResource($show);
    }

    public function watchEpisode(Episode $episode): EpisodeResource
    {
        Auth::user()->episodes()->attach($episode);

        return new EpisodeResource($episode);
    }

    public function unwatchEpisode(Episode $episode): EpisodeResource
    {
        Auth::user()->episodes()->detach($episode);

        return new EpisodeResource($episode);
    }

    public function vote(VoteRequest $request, Show $show): ShowResource
    {
        Auth::user()->shows()->syncWithPivotValues($show, ['vote' => $request->vote], false);

        return new ShowResource($show->fresh());
    }
}
