<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AuthController
{
    public function login(Request $request, Response $response, array $args): Response
    {
        $response = $response->withJson([
            "message" => "Login"
        ]);

        return $response;
    }

    public function refreshToken(Request $request, Response $response, array $args): Response
    {
        $response = $response->withJson([
            "message" => "RefreshToken"
        ]);

        return $response;
    }
}