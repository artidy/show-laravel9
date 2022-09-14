<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
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
            'show_id' => $this->show_id,
            'season' => $this->season,
            'episode_number' => $this->episode_number,
            'air_date' => $this->air_date,
            'comments_count' => $this->comments_count,
            'watched' => $this->watched,
        ];
    }
}
