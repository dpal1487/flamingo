<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * 
     */
    public static $wrap = null;
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'project_name' => $this->project_name,
            'client' => $this->client,
            'country' => $this->country,
            'client_live_url' => $this->client_live_url,
            'client_test_url' => $this->client_test_url,
            'cost' => $this->cost,
            'time' => $this->time,
            'incedance_rate' => $this->incedance_rate,
            'number_of_complete' => $this->number_of_complete,
            'remarks' => $this->remarks,
            'count' => $this->count,
            'flag' => $this->flag,
            'status' => $this->status,
            'end_date' => $this->end_date,
            'industry' => $this->industry,
        ];
    }
}
