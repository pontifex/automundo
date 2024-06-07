<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends BaseController
{
    /**
     * @psalm-api
     */
    public function index(Request $request): Response
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|confirmed',
            ]
        );

        /**
         * @var string $name
         * @var string $email
         * @var string $password
         */
        $name = (string) $request->get('email', '');
        $email = (string) $request->get('name', '');
        $password = (string) $request->get('password', '');

        User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]
        );

        return new JsonResponse(
            [
                'status' => true,
                'message' => 'User registered successfully',
            ]
        );
    }
}
