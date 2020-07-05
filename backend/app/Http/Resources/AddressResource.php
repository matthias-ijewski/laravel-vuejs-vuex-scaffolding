<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'salutation' => new SalutationResource($this->salutation),
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'full_name' => $this->firstname . ' ' . $this->lastname,
            'street' => $this->street,
            'zip' => $this->zip,
            'country' => new CountryResource($this->country),
        ];
    }
}
