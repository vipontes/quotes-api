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
        return $response->withJson($usuarios, $status);
    }

    public function getUsuario(Request $request, Response $response, array $args): Response
    {
        $usuarioId = $request->getAttribute('usuarioId');

        $dataAccessObject = new UsuarioDAO();
        $usuario = $dataAccessObject->getUsuario($usuarioId);

        if ($usuario != null) {
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

        $requiredData = $this->verifyRequiredParameters(['usuarioId'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        if (count($input) <= 1) {
            $status = 400;
            $result = array();
            $result["success"] = false;
            $result["message"] = ENDPOINT_PARAM_COUNT_ERROR;
            return $response->withJson($result, $status);
        }

        $inputData = new UsuarioModel();
        $inputData->setUsuarioId($input['usuarioId']);
        $inputData->setUsuarioNome($input['usuarioNome']);
        $inputData->setUsuarioEmail($input['usuarioEmail']);
        $inputData->setUsuarioSenha($input['usuarioSenha']);
        $inputData->setUsuarioAtivo($input['usuarioAtivo']);
        $inputData->setUsuarioSobre($input['usuarioSobre']);

        $dataAccessObject = new UsuarioDAO();
        $update = $dataAccessObject->putUsuario($inputData);

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

        if ($deleted) {
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

    public function changePassword(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['usuario_id', 'usuario_senha', 'usuario_nova_senha'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        $usuarioId = $input['usuario_id'];
        $usuarioSenha = $input['usuario_senha'];
        $usuarioNovaSenha = $input['usuario_nova_senha'];

        $hash = getenv('HASH_PASSWORD_KEY');
        $senhaHash = $this->hash('sha512', $usuarioSenha, $hash);
        $novaSenhaHash = $this->hash('sha512', $usuarioNovaSenha, $hash);

        $dataAccessObject = new UsuarioDAO();
        $usuarioModel = $dataAccessObject->getUsuario($usuarioId);

        if ($senhaHash != $usuarioModel->getUsuarioSenha()) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = LOGIN_PASSWORD_ERROR;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        if ($senhaHash == $novaSenhaHash) {
            $status = 200;
            $result = array();
            $result["success"] = true;
            $result["message"] = USER_PASSWORD_CHANGED;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        $inputData = new UsuarioModel();
        $inputData->setUsuarioId($usuarioId);
        $inputData->setUsuarioNome(null);
        $inputData->setUsuarioEmail(null);
        $inputData->setUsuarioSenha($novaSenhaHash);
        $inputData->setUsuarioAtivo(null);
        $inputData->setUsuarioSobre(null);

        if ($dataAccessObject->putUsuario($inputData)) {
            $status = 200;
            $result = array();
            $result["success"] = true;
            $result["message"] = USER_PASSWORD_CHANGED;
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

    public function esqueciMinhaSenha(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['usuario_email'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        $usuarioEmail = $input['usuario_email'];

        $hash = getenv('HASH_PASSWORD_KEY');

        $senha = substr(md5(rand(999, 999999)), 0, 8);
        $senhaHash = $this->hash('sha512', $senha, $hash);

        $dataAccessObject = new UsuarioDAO();
        $usuarioModel = $dataAccessObject->getUsuarioPorEmail($usuarioEmail);

        if (is_null($usuarioModel)) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = LOGIN_EMAIL_ERROR;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        /*
            Falta implementar o envio do e-mail e remover o campo newPass do retorno (solução provisória)
        */

        $inputData = new UsuarioModel();
        $inputData->setUsuarioId($usuarioModel->getUsuarioId());
        $inputData->setUsuarioNome(null);
        $inputData->setUsuarioEmail(null);
        $inputData->setUsuarioSenha($senhaHash);
        $inputData->setUsuarioAtivo(null);
        $inputData->setUsuarioSobre(null);

        if ($dataAccessObject->putUsuario($inputData)) {
            $status = 200;
            $result = array();
            $result["success"] = true;
            $result["message"] = USER_PASSWORD_CHANGED;
            $result["newPass"] = $senha;
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
