<?php

namespace App\v1\Controllers;

use App\v1\DAO\QuoteDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class QuoteController extends BaseController
{
    public function getQuotes(Request $request, Response $response, array $args): Response
    {
        $quoteDAO = new QuoteDAO();
        $quotes = $quoteDAO->getQuotes();
        $status = 200;
        header('Content-Type: application/json');
        return $response->withJson(json_encode($quotes), $status);
    }
 
    public function getQuote(Request $request, Response $response, array $args): Response
    {
        $quoteId = $request->getAttribute('quoteId');

        $quoteDAO = new QuoteDAO();
        $quote = $quoteDAO->getQuote($quoteId);

        if ($quote != false) {
            $status = 200;
            header('Content-Type: application/json');
            return $response->withJson(json_encode($quote), $status);
        } else {
            $status = 404;
            $result = array();
            $result["success"] = false;
            $result["message"] = QUOTE_NOT_FOUND;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function postQuote(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['usuario_id', 'quote_conteudo'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        $usuario_id = $input['usuario_id'];
        $quote_conteudo = $input['quote_conteudo'];

        $quoteDAO = new QuoteDAO();
        $quoteId = $quoteDAO->postQuote($usuario_id, $quote_conteudo);

        if (isset($quoteId)) {
            $status = 200;
            $result = array();
            $result['quote_id'] = $quoteId;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        } else {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = $quoteDAO->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function putQuote(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['quote_id'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        if (count($input) <= 1) {
            $status = 400;
            $response["success"] = false;
            $response["message"] = ENDPOINT_PARAM_COUNT_ERROR;
            return $this->response->withJson($response, $status);
        }

        $quoteDAO = new QuoteDAO();
        $update = $quoteDAO->putQuote($input);

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
            $result["message"] = $quoteDAO->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function deleteQuote(Request $request, Response $response, array $args): Response
    {
        $quoteId = $request->getAttribute('quoteId');

        $quoteDAO = new QuoteDAO();
        $deleted = $quoteDAO-deleteQuote($quoteId);

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
            $result["message"] = $quoteDAO->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }
}