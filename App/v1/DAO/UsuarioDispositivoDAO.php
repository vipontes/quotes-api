<?php

namespace App\v1\DAO;

use PDOException;

class UsuarioDispositivoDAO extends Connection
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
    public function updateTokens(int $usuarioId, string $token, string $refreshToken, string $usuarioDispositivo): bool
    {
        $sql = "SELECT usuario_dispositivo_id FROM usuario_dispositivo WHERE usuario_id = :usuario_id AND usuario_dispositivo = :usuario_dispositivo";
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute(array(
                ':usuario_id' => $usuarioId,
                ':usuario_dispositivo' => $usuarioDispositivo
            ));

            $data = $sth->fetch();

            if ( $data != false ) {
                $usuarioDispositivoId = $data['usuario_dispositivo_id'];

                $sql = "UPDATE usuario_dispositivo SET 
                token = :token, 
                refresh_token = :refresh_token 
                WHERE usuario_dispositivo_id = :usuario_dispositivo_id";

                $sth = $this->pdo->prepare($sql);
                $sth->execute(array(
                    ':token' => $token,
                    ':refresh_token' => $refreshToken,
                    ':usuario_dispositivo_id' => $usuarioDispositivoId
                ));

                return ($sth->rowCount() > 0);
            } else {
                $sql = "INSERT INTO usuario_dispositivo (usuario_id, usuario_dispositivo, token, refresh_token) 
                        VALUES (:usuario_id, :usuario_dispositivo, :token, :refresh_token)";

                $params = array(
                    ':usuario_id' => $usuarioId,
                    ':usuario_dispositivo' => $usuarioDispositivo,
                    ':token' => $token,
                    ':refresh_token' => $refreshToken
                );

                $sth = $this->pdo->prepare($sql);
                $sth->execute($params);

                $result = $sth->rowCount();

                return ($result > 0);
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return false;
    }

    /**
     * 
     */
    public function verifyRefreshToken(string $refreshToken): bool
    {
        $sql = "SELECT usuario_dispositivo_id FROM usuario_dispositivo 
                WHERE refresh_token = :refresh_token";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':refresh_token' => $refreshToken));
        $data = $sth->fetch();

        return ($data != false);
    }

    /**
     * 
     */
    public function verifyToken(int $usuarioId, string $usuarioDispositivo, string $token): bool
    {
        $sql = "SELECT token FROM usuario_dispositivo 
                WHERE usuario_id = :usuario_id 
                AND usuario_dispositivo = :usuario_dispositivo";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(':usuario_id' => $usuarioId, 
                            ':usuario_dispositivo' => $usuarioDispositivo));
        $data = $sth->fetch();

        if ( $data == false ) {
            return false;
        }

        return ($data['token'] == $token);
    }
}