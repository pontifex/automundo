<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends BaseController
{
    /**
     * @psalm-api
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $user->tokens()->delete();

        return new JsonResponse(
            [
                'status' => true,
                'message' => 'User logged out',
            ]
        );
    }
}
