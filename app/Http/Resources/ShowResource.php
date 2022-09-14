<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_original' => $this->title_original,
            'status' => $this->status,
            'year' => $this->year,
            'rating' => $this->rating,
            'total_seasons' => $this->total_seasons,
            'total_episodes' => $this->total_episodes,
            'genres' => $this->genres,
            'watch_status' => $this->watch_status,
            'watched_episodes' => $this->watched_episodes,
            'user_vote' => $this->user_vote,
        ];
    }
}
