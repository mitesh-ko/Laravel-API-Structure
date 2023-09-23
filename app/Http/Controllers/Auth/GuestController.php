<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class GuestController extends Controller
{
    /**
     * User registration method
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user['token'] = $user->createToken($user->email)->accessToken;
            return apiResponse(true, __('Your account created successfully.'), $user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return apiException($e);
        }
    }

    /**
     * User login method
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            Auth::attempt($request->only('email', 'password'), $request->boolean('remember'));
            $user = Auth::user();
            if ($user) {
                $user['token'] = $user->createToken($user->email)->accessToken;
                return apiResponse(true, __('User logged in successfully.'), $user);
            }
            return apiResponse(false, __('User not found for given credentials.'), [], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return apiException($e);
        }
    }
}
