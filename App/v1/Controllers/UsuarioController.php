<?php

namespace App\v1\Controllers;

use App\v1\DAO\UsuarioDAO;
use App\v1\Models\UsuarioModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UsuarioController extends BaseController 
{
    public function getUsuarios(Request $request, Response $response, array $args): Response
    {
        $dataAccessObject = new UsuarioDAO();
        $usuarios = $dataAccessObject->getUsuarios();
        $status = 200;
        header('Content-Type: application/json');
        return $response->withJson(json_encode($usuarios), $status);
    }

    public function getUsuario(Request $request, Response $response, array $args): Response
    {
        $usuarioId = $request->getAttribute('usuarioId');

        $dataAccessObject = new UsuarioDAO();
        $usuario = $dataAccessObject->getUsuario($usuarioId);

        if ( $usuario != null ) {
            $status = 200;
            header('Content-Type: application/json');
            return $response->withJson(json_encode($usuario), $status);
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
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['usuario_nome', 'usuario_email', 'usuario_senha'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        $usuario_nome = $input['usuario_nome'];
        $usuario_email = $input['usuario_email'];
        $usuario_senha = $input['usuario_senha'];
        $usuario_sobre = $input['usuario_sobre'] ?? '';

        $hash = getenv('HASH_PASSWORD_KEY');
        $senha_hash = $this->hash('sha512', $usuario_senha, $hash);

        $usuario = new UsuarioModel();
        $usuario->setUsuarioNome($usuario_nome)
            ->setUsuarioEmail($usuario_email)
            ->setUsuarioSenha($senha_hash)
            ->setUsuarioSobre($usuario_sobre);

        $dataAccessObject = new UsuarioDAO();
        $usuarioId = $dataAccessObject->postUsuario($usuario);

        if (isset($usuarioId)) {
            $status = 200;
            $result = array();
            $result['usuario_id'] = $usuarioId;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        } else {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = $dataAccessObject->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function putUsuario(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['usuario_id'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        if (count($input) <= 1) {
            $status = 400;
            $response["success"] = false;
            $response["message"] = ENDPOINT_PARAM_COUNT_ERROR;
            return $this->response->withJson($response, $status);
        }

        $dataAccessObject = new UsuarioDAO();
        $update = $dataAccessObject->putUsuario($input);

        if ($update) {
            $status = 200;
            $result = array();
            $result["success"] = true;
            $result["message"] = PDO_UPDATE_SUCCESS;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        } else {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = $dataAccessObject->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function deleteUsuario(Request $request, Response $response, array $args): Response
    {
        $usuarioId = $request->getAttribute('usuarioId');

        $dataAccessObject = new UsuarioDAO();
        $deleted = $dataAccessObject->deleteUsuario($usuarioId);

        if ( $deleted ) {
            $status = 200;
            $result = array();
            $result["success"] = true;
            $result["message"] = PDO_DELETE_SUCCESS;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        } else {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = $dataAccessObject->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }
}
