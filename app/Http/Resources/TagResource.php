<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="TagResource",
     *     type="object",
     *     title="TagResource",
     *     @OA\Property(
     *          property="id", 
     *          type="number",
     *          example="1", 
     *          description="Tag id"
     *      ),
     *     @OA\Property(
     *          property="name", 
     *          type="string",
     *          example="chackchack", 
     *          description="Tag name"
     *      ),
     * )
     *
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
