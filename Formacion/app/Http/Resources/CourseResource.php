<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category->course_area_name,
            'teacher' => [
                'id' => $this->teacher->id,
                'name' => $this->teacher->name,
            ],
            'duration' => $this->duration,
            'status' => $this->status->value,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
