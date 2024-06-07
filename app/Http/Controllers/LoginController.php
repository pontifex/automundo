<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends BaseController
{
    /**
     * @psalm-api
     */
    public function index(Request $request): Response
    {
        $request->validate(
            [
                'email' => 'required|string|email',
                'password' => 'required',
            ]
        );

        $user = User::where(
            'email',
            $request->get('email', '')
        )->first();

        if (! empty($user)) {
            /**
             * @var User $user
             * @var string $password
             */
            $password = $request->get('password', '');
            if (Hash::check($password, $user->password)) {
                return new JsonResponse(
                    [
                        'status' => true,
                        'message' => 'Login successful',
                        'token' => $user->createToken('myToken')->plainTextToken,
                    ]
                );
            } else {
                return new JsonResponse(
                    [
                        'status' => false,
                        'message' => 'Password did not match',
                    ]
                );
            }
        } else {
            return new JsonResponse(
                [
                    'status' => false,
                    'message' => 'Invalid credentials',
                ]
            );
        }
    }
}
