<?php

namespace App\v1\Middlewares;

use App\v1\DAO\UsuarioDispositivoDAO;
use Firebase\JWT\JWT;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

final class JwtDateTimeMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $tokenPayload = $request->getAttribute('jwt');
        $expireDate = new \DateTime($tokenPayload['expired_at']);
        $usuarioId = $tokenPayload['usuarioId'];
        $usuarioDispositivo = $tokenPayload['usuarioDispositivo'];
        $now = new \DateTime();

        // 1 - Verifica a expiração do token
        if ($expireDate < $now) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["expired"] = true;
            $result["message"] = MIDDLEWARE_EXPIRE_ERROR;
            return $response->withJson($result, $status);
        }

        // 2 -  Verifica se o token é válido
        $usuarioDispositivoDAO = new UsuarioDispositivoDAO();

        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

        $tokenValido = $usuarioDispositivoDAO->verifyToken($usuarioId, $usuarioDispositivo, $token);
        if ($tokenValido == false) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = MIDDLEWARE_TOKEN_NOT_VALID;
            return $response->withJson($result, $status);
        }

        $response = $next($request, $response);
        return $response;
    }
}
