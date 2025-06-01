<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $expand=explode(',', $request->input('expand', ''));
        $fields=explode(',', $request->input('fields', ''));

        $allFields = [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'author_id' => $this->author_id,
            'status' => $this->status,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        $data = [];

        foreach ($allFields as $key => $value) {
            if (empty($fields) || in_array($key, $fields)) {
                $data[$key] = $value;
            }
        }

        foreach ($expand as $field) {
            if ($field === 'category' || $field === 'author') {
                $data[$field] = optional($this->$field)->name;
            }
        }

        return $data;
    }
}
