<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class QuoteReacaoController
{
 
    public function getQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();


        return $response;
    }

    public function postQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function putQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function deleteQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();



        return $response;
    }
}