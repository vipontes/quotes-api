<?php

namespace App\v1\DAO;

class QuoteDAO extends Connection
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
    public function getQuotes(): array
    {
        $sql = "SELECT
            q.quote_id,
            q.usuario_id,
            u.usuario_nome,
            q.quote_data_criacao,
            q.quote_conteudo,
            q.quote_conteudo_ofensivo,
            q.quote_usuario_conteudo_ofensivo_id,
            o.usuario_nome AS usuario_denuncia_nome
            FROM quote q
            INNER JOIN usuario u On q.usuario_id = u.usuario_id
            LEFT JOIN usuario o On q.quote_usuario_conteudo_ofensivo_id = o.usuario_id
            WHERE q.quote_conteudo_ofensivo = 0
            ORDER BY quote_id DESC";

        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    /**
     * 
     */
    public function getQuote(int $quoteId): ?array
    {
        $sql = "SELECT
            q.quote_id,
            q.usuario_id,
            u.usuario_nome,
            q.quote_data_criacao,
            q.quote_conteudo,
            q.quote_conteudo_ofensivo,
            q.quote_usuario_conteudo_ofensivo_id,
            o.usuario_nome AS usuario_denuncia_nome
            FROM quote q
            INNER JOIN usuario u On q.usuario_id = u.usuario_id
            LEFT JOIN usuario o On q.quote_usuario_conteudo_ofensivo_id = o.usuario_id
            WHERE q.quote_id = :quote_id";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':quote_id' => $quoteId));
        $data = $sth->fetch();

        if ($data != false) {
            return $data;
        }

        return null;
    }

    public function postQuote(int $usuarioId, string $quoteConteudo): ?int
    {
        $query = "INSERT INTO quote (usuario_id, quote_conteudo) VALUES (:usuario_id, :quote_conteudo)";
        
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute([
                ':usuario_id' => $usuarioId,
                ':quote_conteudo' => $quoteConteudo
            ]);

            $result = $sth->rowCount();

            if ($result > 0) {
                return $this->pdo->lastInsertId();
            } else {
                $this->lastError = PDO_INSERT_ERROR;
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return null;
    }

    public function putQuote($input): bool {

        $fields = array();
        $values = array();
        $fieldList = array(
            "quote_conteudo_ofensivo",
            "quote_usuario_conteudo_ofensivo_id"
        );
    
        foreach ($fieldList as $value) {
            if (isset($input[$value]) == true) {
                array_push($fields, "{$value} = :{$value}");
                $values[':' . $value] = $input[$value];
            }
        }
    
        $values[':quote_id'] = $input['quote_id'];
    
        $str_fields = implode(",", $fields);
        $query = "UPDATE quote SET " . $str_fields . " WHERE quote_id = :quote_id";

        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($values);

            $result = $sth->rowCount();

            if ($result > 0) {
                return true;
            } else {
                $this->lastError = PDO_UPDATE_ERROR;
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return false;
    }

    public function deleteQuote(int $quoteId): bool {

        $query = "DELETE FROM quote WHERE quote_id = :quote_id";

        try {
            $sth = $this->pdo->prepare($query);
            $result = $sth->execute([':quote_id' => $quoteId]);

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