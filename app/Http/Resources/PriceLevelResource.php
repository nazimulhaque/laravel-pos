<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PriceLevelResource extends JsonResource
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
            'price_level_id' => $this->price_level_id,
            'description' => $this->description,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'last_modified_by' => $this->last_modified_by,
            'last_modified_date' => $this->last_modified_date,
            'record_status' => $this->record_status,
        ];
    }
}
