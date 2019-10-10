<?php

namespace App\v1\Controllers;

use App\v1\DAO\ReacaoDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ReacaoController extends BaseController
{
    public function getReacoes(Request $request, Response $response, array $args): Response
    {
        $reacaoDAO = new ReacaoDAO();
        $reacoes = $reacaoDAO->getReacoes();
        $status = 200;
        header('Content-Type: application/json');
        return $response->withJson(json_encode($reacoes), $status);
    }
 
    public function getReacao(Request $request, Response $response, array $args): Response
    {
        $reacaoId = $request->getAttribute('reacaoId');

        $reacaoDAO = new ReacaoDAO();
        $reacao = $reacaoDAO->getReacao($reacaoId);

        if ( $reacao != null ) {
            $status = 200;
            header('Content-Type: application/json');
            return $response->withJson(json_encode($reacao), $status);
        } else {
            $status = 404;
            $result = array();
            $result["success"] = false;
            $result["message"] = USER_NOT_FOUND;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function postReacao(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['reacao_descricao', 'reacao_icon'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        $reacao_descricao = $input['reacao_descricao'];
        $reacao_icon = $input['reacao_icon'];

        $reacaoDAO = new ReacaoDAO();
        $reacaoId = $reacaoDAO->postReacao($reacao_descricao, $reacao_icon);

        if (isset($reacaoId)) {
            $status = 200;
            $result = array();
            $result['usuario_id'] = $reacaoId;
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        } else {
            $status = 401;
            $result = array();
            $result["success"] = false;
            $result["message"] = $reacaoDAO->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function putReacao(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();

        $requiredData = $this->verifyRequiredParameters(['reacao_id'], $input);
        if ($requiredData['success'] == false) {
            return $response->withJson($requiredData, 404);
        }

        if (count($input) <= 1) {
            $status = 400;
            $response["success"] = false;
            $response["message"] = ENDPOINT_PARAM_COUNT_ERROR;
            return $this->response->withJson($response, $status);
        }

        $reacaoDAO = new ReacaoDAO();
        $update = $reacaoDAO->putReacao($input);

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
            $result["message"] = $usuarioDAO->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }

    public function deleteReacao(Request $request, Response $response, array $args): Response
    {
        $reacaoId = $request->getAttribute('reacaoId');

        $reacaoDAO = new ReacaoDAO();
        $deleted = $reacaoDAO->deleteReacao($reacaoId);

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
            $result["message"] = $usuarioDAO->getLastError();
            header('Content-Type: application/json');
            return $response->withJson($result, $status);
        }
    }
}