<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="PetResource",
     *     type="object",
     *     title="PetResource",
     *     @OA\Property(
     *          property="id", 
     *          type="number",
     *          example="1", 
     *          description="Pet id"
     *      ),
     *     @OA\Property(
     *          property="name", 
     *          type="string",
     *          example="chackchack", 
     *          description="Pet name"
     *      ),
     *      @OA\Property(
     *          property="status", 
     *          type="status",
     *          example="available", 
     *          description="Pet status"
     *      ),
     *      @OA\Schema(
     *          schema="TagCollection",
     *          type="array",
     *          title="TagCollection",
     *          @OA\Items(ref="#/components/schemas/TagCollection") 
     *      ),
     *      @OA\Schema(
     *          schema="CategoryResource",
     *          type="object",
     *          title="CategoryResource",
     *          @OA\Items(ref="#/components/schemas/CategoryResource") 
     *      )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photoUrls' => $this->photoUrls,
            'status' => $this->status,
            'tags' =>  TagResource::collection($this->tags),
            'category' =>  new CategoryResource($this->category),
        ];
    }
}
