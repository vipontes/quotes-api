<?php

namespace App\v1\Controllers;

use App\v1\DAO\UsuarioDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UsuarioController
{
    public function getUsuarios(Request $request, Response $response, array $args): Response
    {
        $usuarioDAO = new UsuarioDAO();
        $usuarios = $usuarioDAO->getUsuarios();
        $status = 200;
        header('Content-Type: application/json');
        return $response->withJson($usuarios, $status);
    }
 
    public function getUsuario(Request $request, Response $response, array $args): Response
    {
        $usuarioId = $request->getAttribute('usuarioId');

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->getUsuario($usuarioId);

        if ( isset($usuario) ) {
            $status = 200;
            header('Content-Type: application/json');
            return $response->withJson($usuario, $status);
        } else {
            $status = 404;
            $result = array();
            $result["success"] = false;
            $result["message"] = USER_NOT_FOUND;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
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