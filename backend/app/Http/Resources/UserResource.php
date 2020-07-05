<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'salutation' => new SalutationResource($this->salutation),
            'fullname' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
            'avatar' => Storage::disk('private')->exists($this->id . '/account/' . $this->avatar) ? Storage::disk('private')->url('/account/' . $this->avatar) : null
        ];
    }
}
