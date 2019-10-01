<?php

namespace App\v1\Controllers;

use App\v1\DAO\UsuarioDAO;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AuthController
{
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $email = $data['email'] ?? '';

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->getUsuarioPorEmail($email);



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