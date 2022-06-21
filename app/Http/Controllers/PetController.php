<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/pet/",
     *      operationId="pet",
     *      tags={"auth"},
     *      description="pet ",
     *      @OA\RequestBody(
     *          request="object",
     *          @OA\JsonContent(
     *               @OA\Schema(
     *                  schema="Pet",
     *                  type="object",
     *                  title="Pet",
     *                  @OA\Items(ref="#/components/schemas/Pet") 
     *               ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="You are offline",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="PetResource",
     *                          type="object",
     *                          title="PetResource",
     *                          @OA\Items(ref="#/components/schemas/PetResource") 
     *                      ),
     *                      
     *              ),
     *          )
     *       )
     *     )
     *
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePetRequest $request)
    {
        $input = $request->validated();
        $pet = Pet::create($input);
        return $this->sendResponse(new PetResource($pet), __('pet.create_success'));
    }

    /**
     * @OA\Get(
     *      path="/pet/{id}",
     *      operationId="pet",
     *      tags={"auth"},
     *      description="pet ",
     *      @OA\Response(
     *          response=200,
     *          description="You are offline",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="PetResource",
     *                          type="object",
     *                          title="PetResource",
     *                          @OA\Items(ref="#/components/schemas/PetResource") 
     *                      ),
     *                      
     *              ),
     *          )
     *       )
     *     )
     *
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        return $this->sendResponse(new PetResource($pet), __('pet.display_content'));
    }


    /**
     * @OA\Put(
     *      path="/pet/{id}",
     *      operationId="pet",
     *      tags={"auth"},
     *      description="pet ",
     *      @OA\RequestBody(
     *          request="object",
     *          @OA\JsonContent(
     *               @OA\Schema(
     *                  schema="Pet",
     *                  type="object",
     *                  title="Pet",
     *                  @OA\Items(ref="#/components/schemas/Pet") 
     *               ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="You are offline",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="PetResource",
     *                          type="object",
     *                          title="PetResource",
     *                          @OA\Items(ref="#/components/schemas/PetResource") 
     *                      ),
     *                      
     *              ),
     *          )
     *       )
     *     )
     *
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePetRequest  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $input = $request->validated();
        $pet->update($input);
        return $this->sendResponse(new PetResource($pet), __('pet.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
