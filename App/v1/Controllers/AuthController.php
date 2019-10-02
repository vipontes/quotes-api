<?php

namespace App\v1\Controllers;

use App\v1\DAO\UsuarioDAO;
use App\v1\Models\UsuarioModel;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AuthController
{
    /**
     * @brief 
     * @param string $algo The algorithm (md5, sha1, whirlpool, etc)
     * @param string $data The data to encode
     * @param string $salt The salt (This should be the same throughout the system probably)
     * @return string The hashed/salted data
     */
    private function hash($algo, $data, $salt): string
    {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);
        return hash_final($context);
    }

    private function updateUserToken(UsuarioModel $usuario): ?array {
        // Dados do usuário
        $tokenPayload = [
            'usuarioId' => $usuario->getUsuarioId(),
            'usuarioNome' => $usuario->getUsuarioNome(),
            'usuarioEmail' => $usuario->getUsuarioEmail(),
            'expired_at' => (new \DateTime())->modify('+2 hour')->format('Y-m-d H:i:s')
        ];
        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

        // 
        $refreshTokenPayload = [
            'usuarioEmail' => $usuario->getUsuarioEmail(),
            'random' => uniqid()
        ];
        $refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));

        $usuarioDAO = new UsuarioDAO();
        $updateOk = $usuarioDAO->updateTokens($usuario->getUsuarioId(), $token, $refreshToken);

        if ( $updateOk ) {
            return ["token" => $token, "refresh_token" => $refreshToken];
        }

        return null;
    }

    public function login(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();

        $email    = $data['email'] ?? '';
        $password = $data['password'] ?? '';

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

        $tokens = $this->updateUserToken($usuario);

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
        $data = $request->getParsedBody();
        $refreshToken = $data['refresh_token'];
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

        $tokens = $this->updateUserToken($usuario);

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