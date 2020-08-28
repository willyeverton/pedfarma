<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
                return $this->jsonResponse($validator->errors(), parent::ERROR);
            }
            $user = $this->save(new User(), $validator->validated());
            return $this->jsonResponse($user);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Get a JWT via given credentials.
     */
    public function token(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if(isset($request->time)) {
                config()->set('jwt.ttl', $request->time);
            }
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->jsonResponse('Credenciais não autorizada', parent::ERROR);
            }
            return $this->jsonResponse([
                'token' => $token,
                'type' => 'bearer'
            ]);
        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
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
                return $this->jsonResponse($validator->errors(), parent::ERROR);
            }
            $user = User::find(JWTAuth::user()->id);
            $user = $this->save($user, $validator->validated());

            return $this->jsonResponse($user);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): JsonResponse
    {
        try {
            $user = User::find(JWTAuth::user()->id);

            $user->delete();

            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->jsonResponse($user);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /*
     * Log the user out (Invalidate the token).
     */
    public function deactivate(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->jsonResponse('Token desativado', parent::SUCCESS);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
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
