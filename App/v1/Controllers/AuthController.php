<?php

namespace App\v1\Controllers;

use App\v1\DAO\{UsuarioDAO, UsuarioDispositivoDAO};
use App\v1\Models\UsuarioModel;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends BaseController
{
    private function updateUserToken(UsuarioModel $usuario, string $usuarioDispositivo): ?array {
        // Dados do usuário
        $tokenPayload = [
            'usuarioId' => $usuario->getUsuarioId(),
            'usuarioNome' => $usuario->getUsuarioNome(),
            'usuarioEmail' => $usuario->getUsuarioEmail(),
            'usuarioDispositivo' => $usuarioDispositivo,
            'expired_at' => (new \DateTime())->modify('+2 hour')->format('Y-m-d H:i:s')
        ];
        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

        // 
        $refreshTokenPayload = [
            'usuarioEmail' => $usuario->getUsuarioEmail(),
            'usuarioDispositivo' => $usuarioDispositivo,
            'random' => uniqid()
        ];
        $refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));

        $dataAccessObject = new UsuarioDispositivoDAO();
        $updateOk = $dataAccessObject->updateTokens($usuario->getUsuarioId(), $token, $refreshToken, $usuarioDispositivo);

        if ( $updateOk ) {
            return ["token" => $token, "refresh_token" => $refreshToken];
        }

        return null;
    }

    public function login(Request $request, Response $response, array $args): Response {
        
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['email', 'password', 'device'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }        

        $email    = $input['email'];
        $password = $input['password'];
        $device   = $input['device'];

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->getUsuarioPorEmail($email);

        if(is_null($usuario)) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = LOGIN_EMAIL_ERROR;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        if ($usuario->getUsuarioAtivo() == 0 ) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = LOGIN_INACTIVE;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        $hash = getenv('HASH_PASSWORD_KEY');
        $senha_hash = $this->hash('sha512', $password, $hash);

        if($senha_hash != $usuario->getUsuarioSenha()) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = LOGIN_PASSWORD_ERROR;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        $tokens = $this->updateUserToken($usuario, $device);

        if ( $tokens != null ) {
            $response = $response->withJson($tokens, 200);        
            return $response;
        } else {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = UPDATE_TOKEN_ERROR;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function refreshToken(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['refresh_token'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }  

        $refreshToken = $input['refresh_token'];

        $refreshTokenDecoded = JWT::decode(
            $refreshToken,
            getenv('JWT_SECRET_KEY'),
            ['HS256']
        );

        $usuarioDAO = new UsuarioDAO();

        $refreshTokenExists = $usuarioDAO->verifyRefreshToken($refreshToken);
        if(!$refreshTokenExists){
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = INVALID_REFRESH_TOKEN;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }

        $usuario = $usuarioDAO->getUsuarioPorEmail($refreshTokenDecoded->usuarioEmail);
        $device = $refreshTokenDecoded->usuarioDispositivo;

        $tokens = $this->updateUserToken($usuario, $device);

        if ( $tokens != null ) {
            $response = $response->withJson($tokens, 200);        
            return $response;
        } else {
            $result = array();
            $result["success"] = false;
            $result["message"] = UPDATE_TOKEN_ERROR;
            header('Content-Type: application/json');
            return $response->withJson($result, 401);
        }
    }
}