<?php

namespace App\v1\DAO;

use App\v1\Models\UsuarioModel;

class UsuarioDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuarioPorEmail(string $email): ?UsuarioModel {

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


        if ( $data != false ) {
            $usuario = new UsuarioModel();

            $usuario->setUsuarioId($data['usuario_id']);
            $usuario->setUsuarioNome($data['usuario_nome']);
            $usuario->setUsuarioEmail($data['usuario_email']);
            $usuario->setUsuarioSenha($data['usuario_senha']);
            $usuario->setUsuarioAtivo($data['usuario_ativo']);
            $usuario->setUsuarioSobre($data['usuario_sobre']);

            return $usuario;
        }

        return null;
    }

}