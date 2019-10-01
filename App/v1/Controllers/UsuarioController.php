<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UsuarioController
{
    public function getUsuarios(Request $request, Response $response, array $args): Response
    {
        $response = $response->withJson([
            "message" => "Usuarios"
        ]);

        return $response;
    }
 
    public function getUsuario(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();


        return $response;
    }

    public function postUsuario(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function putUsuario(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function deleteUsuario(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();



        return $response;
    }
}