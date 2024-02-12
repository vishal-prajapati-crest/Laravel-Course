<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' =>$this->end_time,
            // 'user' => $this->user
            // 'user' => new UserResource($this->user)
            'user' => new UserResource($this->whenLoaded('user')), //the when loaded check the user is loaded if loaded then response.
            'attendees' => AttendeeResource::collection($this->whenLoaded('attendees'))
        ];
    }
}
