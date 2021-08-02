<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DepartmentResource extends JsonResource
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
            'department_name' => $this->department_name,
            'parent_department_id' => $this->parent_department_id,
            'description' => $this->description,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'last_modified_date' => $this->last_modified_date,
        ];
    }
}
