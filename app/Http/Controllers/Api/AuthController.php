<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected array $validation = [
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'max:255', 'email', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
    ];

    /**
     * Register user to use API.
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validator = $this->validateRequest($request);

            if($validator->fails()){
                return $this->jsonResponse(parent::ERROR, 'Failed to validate data', $validator->errors());
            }
            $user = $this->save(new User(), $validator->validated());
            return $this->jsonResponse(parent::SUCCESS, 'User Created', $user);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if(isset($request->jwt_ttl)) {
                config()->set('jwt.ttl', $request->jwt_ttl);
            }
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->jsonResponse(parent::ERROR, 'Credentials unauthorized');
            }
            $response = ['token' => $token,'type' => 'bearer'];
            return $this->jsonResponse(parent::SUCCESS, 'User logged in! Use this authorization bearer token for future requests.', (object)$response);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $validator = $this->validateRequest($request, false);

            if($validator->fails()){
                return $this->jsonResponse(parent::ERROR, 'Failed to validate data', $validator->errors());
            }
            $user_id = JWTAuth::user()->id;
            $user = User::find($user_id);

            if(is_null($user)){
                return $this->jsonResponse(parent::ERROR, 'User not found');
            }
            $user = $this->save($user, $validator->validated());
            return $this->jsonResponse(parent::SUCCESS, 'User updated', $user);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): JsonResponse
    {
        try {
            $user_id = JWTAuth::user()->id;
            $user = User::find($user_id);

            if(is_null($user)){
                return $this->jsonResponse(parent::ERROR, 'User not found');
            }
            $user->delete();
            return $this->jsonResponse(parent::SUCCESS, 'User Deleted!', $user);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /*
     * Log the user out (Invalidate the token).
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->jsonResponse(parent::SUCCESS, 'Logged out');

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Save user credentials.
     */
    private function save(User $user, array $data): User
    {
        isset($data['name'])     ? $user->name = $data['name'] : null;
        isset($data['email'])    ? $user->email = $data['email'] : null;
        isset($data['password']) ? $user->password = Hash::make($data['password']) : null;

        $user->save();
        return $user;
    }
}
