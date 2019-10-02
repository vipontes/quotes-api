<?php

namespace App\v1\Middlewares;

use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

final class JwtDateTimeMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $token = $request->getAttribute('jwt');
        $expireDate = new \DateTime($token['expired_at']);
        $now = new \DateTime();

        if ($expireDate < $now) {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = MIDDLEWARE_EXPIRE_ERROR;
            return $response->withJson($result, $status);
        }

        $response = $next($request, $response);
        return $response;
    }
}
