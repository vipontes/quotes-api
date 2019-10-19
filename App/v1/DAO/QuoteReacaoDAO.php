<?php

namespace App\v1\DAO;

use App\v1\Models\QuoteReacaoModel;

class QuoteReacaoDAO extends Connection
{
    private $lastError = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the value of lastError
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * 
     */
    public function getQuoteReacao(int $usuarioId, int $quoteId): ?UsuarioModel
    {
        $sql = "SELECT
            q.quote_id,
            q.usuario_id,
            q.reacao_id,
            r.reacao_descricao,
            r.reacao_icon,
            q.quote_reacao_data
            FROM quote_reacao q
            INNER JOIN reacao r ON q.reacao_id = r.reacao_id
            WHERE q.quote_id = :quote_id AND q.usuario_id = :usuario_id";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':quote_id' => $quoteId, ':usuario_id' => $usuarioId));
        $data = $sth->fetch();

        if ($data != false) {
            $quoteReacao = new QuoteReacaoModel();

            $quoteReacao->setQuoteId($data['quote_id'])
                ->setUsuarioId($data['usuario_id'])
                ->setReacaoId($data['reacao_id'])
                ->setQuoteReacaoData($data['quote_reacao_data'])
                ->setReacaoDescricao($data['reacao_descricao'])
                ->setReacaoIcon($data['reacao_icon']);

            return $quoteReacao;
        }

        return null;
    }

    /**
     * 
     */
    public function getQuoteReacaoCount(int $quoteId): array
    {
        $sql = "SELECT COUNT(*) AS qtd FROM quote_reacao WHERE quote_id = :quote_id AND reacao_id = 1";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':quote_id' => $quoteId));
        $data = $sth->fetch();
        $up = $data['qtd'];

        $sql = "SELECT COUNT(*) AS qtd FROM quote_reacao WHERE quote_id = :quote_id AND reacao_id = 2";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':quote_id' => $quoteId));
        $data = $sth->fetch();
        $down = $data['qtd'];

        return [$up, $down];
    }

    /**
     * 
     */
    public function postQuoteReacao(int $usuarioId, int $quoteId, int $reacaoId): ?int
    {
        $query = "DELETE FROM quote_reacao WHERE usuario_id = :usuario_id AND quote_id = :quote_id";

        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute([':usuario_id' => $usuarioId, ':quote_id' => $quoteId]);


            $query = "INSERT INTO quote_reacao (usuario_id, quote_id, reacao_id) VALUES (:usuario_id, :quote_id, :reacao_id)";
            $sth = $this->pdo->prepare($query);
            $sth->execute([
                ':usuario_id' => $usuarioId,
                ':quote_id' => $quoteId,
                ':reacao_id' => $reacaoId
            ]);

            $result = $sth->rowCount();

            if ($result > 0) {
                return 1;
            } else {
                $this->lastError = PDO_INSERT_ERROR;
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return null;
    }

    /**
     * 
     */
    public function deleteQuoteReacao(int $quoteId, int $usuarioId): bool
    {

        $query = "DELETE FROM quote_reacao WHERE quote_id = :quote_id AND usuario_id = :usuario_id";

        try {
            $sth = $this->pdo->prepare($query);
            $result = $sth->execute([':quote_id' => $quoteId, ':usuario_id' => $usuarioId]);

            if ($result > 0) {
                return true;
            } else {
                $this->lastError = PDO_DELETE_ERROR;
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return false;
    }
}
