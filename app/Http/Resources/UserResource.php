<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="UserResource",
     *     type="object",
     *     title="UserResource",
     *     @OA\Property(
     *          property="id", 
     *          type="number",
     *          example="1", 
     *          description="User id"
     *      ),
     *     @OA\Property(
     *          property="name", 
     *          type="string",
     *          example="saife", 
     *          description="User name"
     *      ),
     *      @OA\Property(
     *          property="email", 
     *          type="email",
     *          example="saifeddinne@gmail.com", 
     *          description="User email"
     *      ),
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
            'email' => $this->email,
        ];
    }
}
