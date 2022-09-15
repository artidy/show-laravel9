<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\EpisodeCollection;
use App\Http\Resources\ShowCollection;
use App\Http\Resources\UserResource;
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
}
