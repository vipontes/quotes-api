<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ReacaoController extends BaseController
{
    public function getReacoes(Request $request, Response $response, array $args): Response
    {


        return $response;
    }
 
    public function getReacao(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();


        return $response;
    }

    public function postReacao(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function putReacao(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function deleteReacao(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();



        return $response;
    }
}