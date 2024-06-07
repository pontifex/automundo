<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends BaseController
{
    /**
     * @psalm-api
     */
    public function index(): Response
    {
        $userData = Auth::user();

        return new JsonResponse(
            [
                'status' => true,
                'message' => 'Profile information',
                'data' => $userData,
            ]
        );
    }
}
