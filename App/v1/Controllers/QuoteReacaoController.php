<?php

namespace App\v1\Controllers;

use App\v1\DAO\QuoteReacaoDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class QuoteReacaoController extends BaseController
{
    public function getQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $usuarioId = $request->getAttribute('usuarioId');
        $quoteId = $request->getAttribute('quoteId');

        $dataAccessObject = new QuoteReacaoDAO();
        $reacao = $dataAccessObject->getQuoteReacao($usuarioId, $quoteId);

        if ( $reacao != null ) {
            $status = 200;
            header('Content-Type: application/json');
            return $response->withJson($reacao, $status);
        } else {
            $status = 404;
            $result = array();
            $result["success"] = false;
            $result["message"] = USER_NOT_FOUND;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }
 
    public function getQuoteReacaoCount(Request $request, Response $response, array $args): Response
    {
        $quoteId = $request->getAttribute('quoteId');

        $dataAccessObject = new QuoteReacaoDAO();
        $count = $dataAccessObject->getQuoteReacaoCount($quoteId);

        if ( $count != null ) {
            $status = 200;
            header('Content-Type: application/json');
            return $response->withJson(array('up' => $count[0], 'down' => $count[1]), $status);
        } else {
            $status = 404;
            $result = array();
            $result["success"] = false;
            $result["message"] = USER_NOT_FOUND;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function postQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['usuario_id', 'quote_id', 'reacao_id'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        $usuarioId = $input['usuario_id'];
        $quoteId = $input['quote_id'];
        $reacaoId = $input['reacao_id'];

        $dataAccessObject = new QuoteDAO();
        $result = $dataAccessObject->postQuoteReacao($usuarioId, $quoteId, $reacaoId);

        if (isset($result)) {
            $status = 200;
            $result = array();
            $result["usuario_id"] = $usuarioId;
            $result["quote_id"] = $quoteId;
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

    public function deleteQuoteReacao(Request $request, Response $response, array $args): Response
    {
        $quoteId = $request->getAttribute('quoteId');
        $usuarioId = $request->getAttribute('usuarioId');

        $dataAccessObject = new QuoteReacaoDAO();
        $deleted = $dataAccessObject->deleteQuoteReacao($quoteId, $usuarioId);

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
            $result["message"] = $dataAccessObject->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }
}