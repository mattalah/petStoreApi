<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexBystatusPetRequest;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetResource;
use App\Models\Category;
use App\Models\Pet;
use App\Models\Tag;

class PetController extends AppBaseController
{

    /**
     * @OA\Get(
     *      path="/pet/findByStatus",
     *      operationId="pet",
     *      tags={"pet"},
     *      description="Finds Pets by status",
     *      @OA\RequestParam(
     *          request="string",
     *          @OA\JsonContent(
     *               @OA\Obect(
     *                  property="status"
     *                  type="string",
     *               ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="PetCollection",
     *                          type="Array",
     *                          title="PetCollection",
     *                          @OA\Items(ref="#/components/schemas/PetCollection") 
     *                      ),
     *                      
     *              ),
     *          )
     *       )
     *     )
     *
     */

    /**
     * Display a listing of the pet by status.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByStatus(IndexBystatusPetRequest $request)
    {
        $input = $request->validated();
        return response()->json(PetResource::collection(Pet::where('status', $input['status'])->get()));
    }

    /**
     * @OA\Post(
     *      path="/pet/",
     *      operationId="pet",
     *      tags={"pet"},
     *      description="Add a new prt to the store",
     *      @OA\RequestBody(
     *          request="object",
     *          description="Pet object that needs to be added to the store",
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
     *          description="successful operation",
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
        $pet = Pet::create([
            'name' => $input['name'],
            'status' => $input['status'],
            'photoUrls' => json_encode($input['photoUrls']),
        ]);
        if (isset($input['category'])) {
            $category = Category::create(['name' => $input['category']['name']]);
            $pet->category()->associate($category);
        }
        if (!empty($input['tags'])) {
            foreach ($input['tags'] as $tag) {
                $tg = Tag::firstOrCreate(['name' => $tag['name']]);
                $pet->tags()->attach($tg->id);
            }
        }
        $pet->save();
        return response()->json(new PetResource($pet));
    }

    /**
     * @OA\Put(
     *      path="/pet/{id}",
     *      operationId="pet",
     *      tags={"pet"},
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
     *          description="successful operation",
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
    public function update(UpdatePetRequest $request)
    {
        $input = $request->validated();
        if (!Pet::where('id', $input['id'])->exist()) {
            return  response()->json('Pet not found', 404);
        }
        $pet = Pet::where('id', $input['id'])->first();
        $pet->update([
            'name' => $input['name'],
            'status' => $input['status'],
            'photoUrls' => json_encode($input['photoUrls']),
        ]);
        if ($pet->category()->exists()) {
            $pet->category()->dissociate();
        }
        if (isset($input['category'])) {
            $category = Category::create(['name' => $input['category']['name']]);
            $pet->category()->associate($category);
        }
        if ($pet->tags()->exists()) {
            $pet->tags()->detach();
        }
        if (!empty($input['tags'])) {
            foreach ($input['tags'] as $tag) {
                $tg = Tag::firstOrCreate(['name' => $tag['name']]);
                $pet->tags()->attach($tg->id);
            }
        }
        $pet->save();
        return  response()->json(new PetResource($pet));
    }

    /**
     * @OA\Delete(
     *      path="/pet/{id}",
     *      operationId="pet",
     *      tags={"pet"},
     *      description="delete pet",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                      
     *              ),
     *          )
     *       )
     *     )
     *
     */
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $petId)
    {
        if (Pet::where('id', $petId)->doesntExist()) {
            return  response()->json('Pet not found', 404);
        }
        Pet::where('id', $petId)->delete();
        return response()->json('deleted done');
    }
}
