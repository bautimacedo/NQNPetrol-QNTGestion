<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PilotAvailabilityResource extends JsonResource
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
            'full_name' => $this->full_name,
            'user_telegram_id' => $this->user_telegram_id,
            'status' => $this->status,
            'has_valid_license' => $this->hasValidLicense(),
            'licenses' => $this->whenLoaded('licenses', function () {
                return $this->licenses->map(function ($license) {
                    return [
                        'id' => $license->id,
                        'license_number' => $license->license_number,
                        'category' => $license->category,
                        'expiration_date' => $license->expiration_date->format('Y-m-d'),
                        'is_valid' => $license->isValid(),
                        'expires_soon' => $license->expiresSoon(),
                    ];
                });
            }),
        ];
    }
}
