<?php

namespace App\v1\DAO;

use App\v1\Models\UsuarioModel;
use PDOException;

class UsuarioDAO extends Connection
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
    public function getUsuarioPorEmail(string $email): ?UsuarioModel
    {
        $sql = "SELECT 
            usuario_id, 
            usuario_nome, 
            usuario_email, 
            usuario_senha, 
            usuario_ativo, 
            usuario_sobre 
            FROM usuario 
            WHERE usuario_email = :usuario_email";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':usuario_email' => $email));
        $data = $sth->fetch();

        if ($data != false) {
            $usuario = new UsuarioModel();

            $usuario->setUsuarioId($data['usuario_id'])
                ->setUsuarioNome($data['usuario_nome'])
                ->setUsuarioEmail($data['usuario_email'])
                ->setUsuarioSenha($data['usuario_senha'])
                ->setUsuarioAtivo($data['usuario_ativo'])
                ->setUsuarioSobre($data['usuario_sobre']);

            return $usuario;
        }

        return null;
    }

    /**
     * 
     */
    public function getUsuarios(): array
    {
        $sql = "SELECT
            usuario_id,
            usuario_nome,
            usuario_email,
            usuario_senha,
            usuario_ativo,
            usuario_sobre
            FROM usuario
            ORDER BY usuario_nome ASC";

        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $data = $sth->fetchAll();

        $res = [];

        foreach ($data as $item) {
            $usuario = new UsuarioModel();

            $usuario->setUsuarioId($item['usuario_id'])
                ->setUsuarioNome($item['usuario_nome'])
                ->setUsuarioEmail($item['usuario_email'])
                ->setUsuarioSenha($item['usuario_senha'])
                ->setUsuarioAtivo($item['usuario_ativo'])
                ->setUsuarioSobre($item['usuario_sobre']);

                $res[] = $usuario;
        }

        return $res;
    }

    /**
     * 
     */
    public function getUsuario(int $usuarioId): ?UsuarioModel
    {
        $sql = "SELECT
            usuario_id,
            usuario_nome,
            usuario_email,
            usuario_senha,
            usuario_ativo,
            usuario_sobre
            FROM usuario
            WHERE usuario_id = :usuario_id";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':usuario_id' => $usuarioId));
        $data = $sth->fetch();

        if ($data != false) {
            $usuario = new UsuarioModel();

            $usuario->setUsuarioId($data['usuario_id'])
                ->setUsuarioNome($data['usuario_nome'])
                ->setUsuarioEmail($data['usuario_email'])
                ->setUsuarioSenha($data['usuario_senha'])
                ->setUsuarioAtivo($data['usuario_ativo'])
                ->setUsuarioSobre($data['usuario_sobre']);

            return $usuario;
        }

        return null;
    }

    public function postUsuario(UsuarioModel $usuario): ?int
    {
        $query = "INSERT INTO usuario (
            usuario_nome,
            usuario_email,
            usuario_senha,
            usuario_sobre
        ) VALUES (
            :usuario_nome,
            :usuario_email,
            :usuario_senha,
            :usuario_sobre
        )";
        
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute([
                ':usuario_nome' => $usuario->getUsuarioNome(),
                ':usuario_email' => $usuario->getUsuarioEmail(),
                ':usuario_senha' => $usuario->getUsuarioSenha(),
                ':usuario_sobre' => $usuario->getUsuarioSobre()
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

    public function putUsuario(UsuarioModel $inputData): bool {

        $fields = array();
        $values = array();

        if ( $inputData->getUsuarioNome() != null ) {
            array_push($fields, "usuario_nome = :usuario_nome");
            $values[':usuario_nome'] = $inputData->getUsuarioNome();
        }

        if ( $inputData->getUsuarioEmail() != null ) {
            array_push($fields, "usuario_email = :usuario_email");
            $values[':usuario_email'] = $inputData->getUsuarioEmail();
        }
  
        if ( $inputData->getUsuarioSenha() != null ) {
            array_push($fields, "usuario_senha = :usuario_senha");
            $values[':usuario_senha'] = $inputData->getUsuarioSenha();
        }
    
        if ( $inputData->getUsuarioAtivo() != null ) {
            array_push($fields, "usuario_ativo = :usuario_ativo");
            $values[':usuario_ativo'] = $inputData->getUsuarioAtivo();
        }    
        
        if ( $inputData->getUsuarioSobre() != null ) {
            array_push($fields, "usuario_sobre = :usuario_sobre");
            $values[':usuario_sobre'] = $inputData->getUsuarioSobre();
        }

        $values[':usuario_id'] = $inputData->getUsuarioId();
    
        $str_fields = implode(",", $fields);
        $query = "UPDATE usuario SET " . $str_fields . " WHERE usuario_id = :usuario_id";

        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($values);

            //$result = $sth->rowCount();

            $error_array = $sth->errorInfo();
            $error = (int) $error_array[1];

            if ($error == 0) {
                return true;
            } else {
                $this->lastError = PDO_UPDATE_ERROR;
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return false;
    }

    public function deleteUsuario(int $usuarioId): bool {

        $query = "DELETE FROM usuario WHERE usuario_id = :usuario_id";

        try {
            $sth = $this->pdo->prepare($query);
            $result = $sth->execute([':usuario_id' => $usuarioId]);

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
