<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerSurveyResources extends JsonResource
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
            'uid' => $this->uid,
            'starting_ip' => $this->starting_ip,
            'end_ip' => $this->end_ip,
            'status' => $this->status,
            'date' => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'duration' => $this->created_at->diff($this->end_survey)->format('%H:%I:%S'),
            'project' => $this->project,
            'partner' => $this->partner
        ];
    }
}
