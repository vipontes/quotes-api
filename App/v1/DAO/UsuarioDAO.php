<?php

namespace App\v1\DAO;

use App\v1\Models\UsuarioModel;

class UsuarioDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
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
    public function updateTokens(int $usuarioId, string $token, string $refreshToken): bool {
        $sql = "UPDATE usuario SET 
                token = :token, 
                refresh_token = :refresh_token 
                WHERE usuario_id = :usuario_id";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':token' => $token, 
                            ':refresh_token' => $refreshToken, 
                            ':usuario_id' => $usuarioId));
        
        return ($sth->rowCount() > 0);
    }

    /**
     * 
     */
    public function verifyRefreshToken(string $refreshToken): bool
    {
        $sql = "SELECT usuario_id FROM usuario 
                WHERE refresh_token = :refresh_token";
        
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':refresh_token' => $refreshToken));
        $data = $sth->fetch();
        
        return ($data != false);
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
        return $data;
    }

    /**
     * 
     */
    public function getUsuario(int $usuarioId): ?array
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
            return $data;
        }

        return null;
    }

}
