<?php

namespace App\v1\Controllers;

use App\v1\DAO\UsuarioDAO;
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

        $tokenPayload = [
            'usuarioId' => $usuario->getUsuarioId(),
            'usuarioNome' => $usuario->getUsuarioNome(),
            'usuarioEmail' => $usuario->getUsuarioEmail(),
            'expired_at' => (new \DateTime())->modify('+2 hour')->format('Y-m-d H:i:s')
        ];

        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));
        $refreshTokenPayload = [
            'usuarioEmail' => $usuario->getUsuarioEmail(),
            'random' => uniqid()
        ];
        $refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));

        $response = $response->withJson([
            "token" => $token,
            "refresh_token" => $refreshToken
        ], 200);        

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