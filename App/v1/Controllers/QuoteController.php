<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class QuoteController
{
    public function getQuotes(Request $request, Response $response, array $args): Response
    {


        return $response;
    }
 
    public function getQuote(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();


        return $response;
    }

    public function postQuote(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function putQuote(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();



        return $response;
    }

    public function deleteQuote(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();



        return $response;
    }
}