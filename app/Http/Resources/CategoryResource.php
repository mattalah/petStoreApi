<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="CategoryResource",
     *     type="object",
     *     title="CategoryResource",
     *     @OA\Property(
     *          property="id", 
     *          type="number",
     *          example="1", 
     *          description="Category id"
     *      ),
     *     @OA\Property(
     *          property="name", 
     *          type="string",
     *          example="chackchack", 
     *          description="Category name"
     *      ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
