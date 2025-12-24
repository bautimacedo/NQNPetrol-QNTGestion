<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DroneAvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dock' => $this->dock,
            'site' => $this->site,
            'organization' => $this->organization,
            'Latitud' => $this->Latitud,
            'Longitud' => $this->Longitud,
            'available' => $this->isAvailable(),
            'batteries' => $this->whenLoaded('batteries', function () {
                return $this->batteries->map(function ($battery) {
                    return [
                        'id' => $battery->id,
                        'serial_number' => $battery->serial_number,
                        'flight_count' => $battery->flight_count,
                        'status' => $battery->status,
                        'usable_for_flight' => $battery->isUsableForFlight(),
                    ];
                });
            }),
        ];
    }
}
