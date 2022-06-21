<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\{AuthLoginRequest, AuthRegisterRequest};
use App\Http\Resources\UserResource;

use Illuminate\{Http\Request, Support\Facades\Auth};


class AuthController extends Controller
{

    /**
     * AuthController constructor.
     * 
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="login",
     *      tags={"auth"},
     *      summary="log in",
     *      description="log in",
     *      @OA\RequestBody(
     *          request="object",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 property="email",
     *                 type="email",
     *              ),
     *              @OA\Property(
     *                 property="password",
     *                 type="password",
     *              ),
     *          )
     *      )
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Property(
     *                          property="token",
     *                          type="object",
     *                              @OA\Property(
     *                                  property="access_token",
     *                                  type="string",
     *                              ),
     *                              @OA\Property(
     *                                  property="token_type",
     *                                  type="string",
     *                                  example="Bearer"
     *                              ),
     *                      ),
     *                      @OA\Schema(
     *                          schema="UserResource",
     *                          type="object",
     *                          title="UserResource",
     *                          @OA\Items(ref="#/components/schemas/UserResource") 
     *                      )
     *              ),
     *          )
     *       ),
     *       @OA\Response(response=401, description="These credentials do not match our records."),
     *     )
     *
     * Returns token and user details
     */

    /**
     * @param AuthLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     **/
    public function login(AuthLoginRequest $request)
    {
        $credentials = ['password' => $request->password, 'email' => $request->email];
        if (!Auth::attempt($credentials)) {
            return $this->sendError([
                __('auth.failed')
            ], 401);
        }

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
        }
        $user = $request->user();

        return $this->sendTokenResponse($user);
    }


    /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="register",
     *      tags={"auth"},
     *      description="register new user",
     *      @OA\RequestBody(
     *          request="object",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 property="email",
     *                 type="email",
     *              ),
     *              @OA\Property(
     *                 property="password",
     *                 type="password",
     *              ),
     *              @OA\Property(
     *                 property="name",
     *                 type="string",
     *              ),
     *          )
     *      )
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="UserResource",
     *                          type="object",
     *                          title="UserResource",
     *                          @OA\Items(ref="#/components/schemas/UserResource") 
     *                      ),
     *                      @OA\Property(
     *                          property="message",
     *                          type="string",
     *                      ),
     *              ),
     *          )
     *       )
     *     )
     *
     */
    /**
     * @param AuthRegisterRequest $request
     * @param $role
     * @return mixed
     *
     */
    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        return $this->sendResponse(new UserResource($user), __('auth.verification.registered_account'));
    }

/**
     * @OA\Get(
     *      path="/auth/logout",
     *      operationId="logout",
     *      tags={"auth"},
     *      description="logout ",
     *      @OA\Response(
     *          response=200,
     *          description="You are offline",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="UserResource",
     *                          type="object",
     *                          title="UserResource",
     *                          @OA\Items(ref="#/components/schemas/UserResource") 
     *                      ),
     *                      @OA\Property(
     *                          property="message",
     *                          type="string",
     *                      ),
     *              ),
     *          )
     *       )
     *     )
     *
     */

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendSuccess(__('auth.logout_success'));
    }


    /**
     * @param $user
     * @return mixed
     */
    private function sendTokenResponse($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->sendResponse([
            'token' => [
                'access_token' => $tokenResult->plainTextToken,
                'token_type' => 'Bearer',
            ],
            'user' => new UserResource($user),
        ], __('auth.login_success'));
    }
}
