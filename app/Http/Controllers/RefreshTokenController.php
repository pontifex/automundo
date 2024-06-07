<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenController extends BaseController
{
    /**
     * @psalm-api
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $newToken = $user->createToken('myNewToken')
            ->plainTextToken;

        return new JsonResponse(
            [
                'status' => true,
                'message' => 'Refresh token',
                'access_token' => $newToken,
            ]
        );
    }
}
