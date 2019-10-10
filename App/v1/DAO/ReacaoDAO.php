<?php

namespace App\v1\DAO;

use App\v1\Models\ReacaoModel;

class ReacaoDAO extends Connection
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
    public function getReacoes(): array
    {
        $sql = "SELECT
            reacao_id,
            reacao_descricao,
            reacao_icon
            FROM reacao
            ORDER BY reacao_id ASC";

        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $data = $sth->fetchAll();

        $res = [];

        foreach ($data as $item) {
            $reacao = new ReacaoModel();
            $reacao->setReacaoId($item['reacao_id'])
                ->setReacaoDescricao($item['reacao_descricao'])
                ->setReacaoIcon($item['reacao_icon']);
                
                $res[] = $reacao;
        }

        return $res;
    }

    /**
     * 
     */
    public function getReacao(int $reacaoId): ?ReacaoModel
    {
        $sql = "SELECT
            reacao_id,
            reacao_descricao,
            reacao_icon
            FROM reacao
            WHERE reacao_id = :reacao_id";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':reacao_id' => $reacaoId));
        $data = $sth->fetch();

        if ($data != false) {
            $reacao = new ReacaoModel();
            $reacao->setReacaoId($data['reacao_id'])
                ->setReacaoDescricao($data['reacao_descricao'])
                ->setReacaoIcon($data['reacao_icon']);

            return $reacao;
        }

        return null;
    }

    /**
     * 
     */
    public function postReacao(int $reacaoDescricao, string $reacaoIcon): ?int
    {
        $query = "INSERT INTO reacao (reacao_descricao, reacao_icon) VALUES (:reacao_descricao, :reacao_icon)";
        
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute([
                ':reacao_descricao' => $reacaoDescricao,
                ':reacao_icon' => $reacaoIcon
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
    
    /**
     * 
     */
    public function putReacao($input): bool {

        $fields = array();
        $values = array();
        $fieldList = array(
            "reacao_descricao",
            "reacao_icon"
        );
    
        foreach ($fieldList as $value) {
            if (isset($input[$value]) == true) {
                array_push($fields, "{$value} = :{$value}");
                $values[':' . $value] = $input[$value];
            }
        }
    
        $values[':reacao_id'] = $input['reacao_id'];
    
        $str_fields = implode(",", $fields);
        $query = "UPDATE reacao SET " . $str_fields . " WHERE reacao_id = :reacao_id";

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

    /**
     * 
     */
    public function deleteReacao(int $reacaoId): bool {

        $query = "DELETE FROM reacao WHERE reacao_id = :reacao_id";

        try {
            $sth = $this->pdo->prepare($query);
            $result = $sth->execute([':reacao_id' => $reacaoId]);

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