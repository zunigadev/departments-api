<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'formatted_name' => $this->formatted_name,
            'level' => $this->level,
            'employee_count' => $this->employee_count,
            'ambassador_name' => $this->ambassador_name,
            'parent_id' => $this->parent_id,
            'parent' => new DepartmentResource($this->whenLoaded('parent')),
            'children' => DepartmentResource::collection($this->whenLoaded('children')),
            'children_count' => $this->when($this->relationLoaded('children'), function () {
                return $this->children->count();
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}